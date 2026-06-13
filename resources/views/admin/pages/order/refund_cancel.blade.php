@extends('admin.layout.app')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <style>
        .table td img {
            width: 60px;
            height: 60px;
            border-radius: 100%;
        }

        .status-card {
            cursor: pointer;
        }

        /* লেআউট পজিশনিং */
        .dt-buttons {
            float: right !important;
            margin-bottom: 15px;
        }

        .dt-length {
            float: left !important;
            margin-bottom: 15px;
        }

        .dt-search {
            float: right !important;
            clear: both;
            margin-bottom: 15px;
        }

        /* বাটনগুলোর গ্যাপ এবং টেক্সট সাইজ */
        .dt-buttons .btn {
            margin-left: 5px;
            border-radius: 4px !important;
            font-weight: 500;
            font-size: 14px;
            padding: 6px 12px;
            border: none !important;
            /* ডিফল্ট বর্ডার রিমুভ করার জন্য */
        }

        /* 🎨 স্ক্রিনশট অনুযায়ী ব্যাকগ্রাউন্ড কালার ফিক্স (DataTables এর জন্য) */
        .btn-print-custom {
            background-color: #00ca52 !important;
            /* সবুজ */
            color: #ffffff !important;
        }

        .btn-pdf-custom {
            background-color: #ff0000 !important;
            /* লাল */
            color: #ffffff !important;
        }

        .btn-csv-custom {
            background-color: #1e74ff !important;
            /* নীল */
            color: #ffffff !important;
        }

        .btn-excel-custom {
            background-color: #00ca52 !important;
            /* সবুজ */
            color: #ffffff !important;
        }
    </style>
@endpush

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 card-title">Refund/Cancel Order Request List </h4>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="refundTable" class="table mb-0 w-100 table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Order Type</th>
                                    <th>Order</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($refundCancelOrders as $order)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $order->type }}</td>
                                        <td>
                                            @php
                                                $mainOrder = App\Models\Order::find($order->order_id);
                                            @endphp

                                            @if($mainOrder)
                                                <div class="order-info">
                                                    <span class="mb-1 d-block fw-bold text-primary">
                                                        <i class="fa fa-hashtag"></i> {{ $mainOrder->invoiceID }}
                                                    </span>

                                                    <span class="my-2 fs-6 d-block text-dark fw-medium small">
                                                        <strong>Total:</strong> {{ number_format($mainOrder->total, 2) }}
                                                    </span>

                                                    <span class="d-block text-muted style" style="font-size: 12px;">
                                                        <i class="fa fa-calendar-alt"></i>
                                                        {{ date('d M, Y', strtotime($mainOrder->order_date)) }}
                                                    </span>
                                                </div>
                                            @else
                                                <span class="text-danger small">Order Not Found</span>
                                            @endif
                                        </td>
                                        <td>{{ $order->reason }}</td>
                                        <td>
                                            @if ($order->status == 0)
                                                <span class="badge bg-danger" id="status-badge-{{ $order->id }}">Pending</span>
                                            @else
                                                <span class="badge bg-success" id="status-badge-{{ $order->id }}">Complete</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-sm {{ $order->status == 0 ? 'btn-success' : 'btn-warning' }}"
                                                onclick="changeOrderStatus({{ $order->id }}, {{ $order->status }})"
                                                id="status-btn-{{ $order->id }}">
                                                <i class="fa {{ $order->status == 0 ? 'fa-check' : 'fa-undo' }}"></i>
                                                {{ $order->status == 0 ? 'Mark Complete' : 'Mark Pending' }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <script>
        $(document).ready(function () {
            $('#refundTable').DataTable({
                "paging": true,
                "lengthMenu": [10, 25, 50, 100],
                "pageLength": 10,
                "searching": true,
                "ordering": true,
                "info": true,
                "dom": '<"d-flex justify-content-between align-items-center"lB>frtip',
                "buttons": [
                    {
                        extend: 'print',
                        text: 'Print Table',
                        className: 'btn btn-print-custom'
                    },
                    {
                        extend: 'pdf',
                        text: 'Download PDF',
                        className: 'btn btn-pdf-custom',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'CSV Export',
                        className: 'btn btn-csv-custom'
                    },
                    {
                        extend: 'excel',
                        text: 'Excel Export',
                        className: 'btn btn-excel-custom'
                    }
                ]
            });
        });
    </script>
    <script>
        function changeOrderStatus(orderId, currentStatus) {
            let textMessage = currentStatus == 0
                ? "Do you want to mark this request as Complete?"
                : "Do you want to revert this request back to Pending?";

            let confirmBtnText = currentStatus == 0 ? "Yes, Complete it!" : "Yes, set Pending!";

            Swal.fire({
                title: 'Are you sure?',
                text: textMessage,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: currentStatus == 0 ? '#198754' : '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: confirmBtnText
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ url('/admin/refund-order/toggle-status') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: orderId
                        },
                        success: function (response) {
                            if (response.status) {
                                Swal.fire(
                                    'Updated!',
                                    response.message,
                                    'success'
                                );

                                let badge = $('#status-badge-' + orderId);
                                let button = $('#status-btn-' + orderId);

                                if (response.new_status == 1) {
                                    badge.removeClass('bg-danger').addClass('bg-success').text('Complete');
                                    button.removeClass('btn-success').addClass('btn-warning')
                                        .html('<i class="fa fa-undo"></i> Mark Pending');
                                    button.attr('onclick', 'changeOrderStatus(' + orderId + ', 1)');
                                } else {
                                    badge.removeClass('bg-success').addClass('bg-danger').text('Pending');
                                    button.removeClass('btn-warning').addClass('btn-success')
                                        .html('<i class="fa fa-check"></i> Mark Complete');
                                    button.attr('onclick', 'changeOrderStatus(' + orderId + ', 0)');
                                }
                            }
                        },
                        error: function (xhr) {
                            Swal.fire(
                                'Failed!',
                                'Something went wrong. Please try again.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@endpush
