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

        .dt-buttons .btn {
            margin-left: 5px;
            border-radius: 4px !important;
            font-weight: 500;
            font-size: 14px;
            padding: 6px 12px;
            border: none !important;
        }

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
                        <h4 class="mb-0 card-title">Stripe Payment Order List </h4>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="refundTable" class="table mb-0 w-100 table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Order ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stripe_payment_lists as $order)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $order->invoice_id }}</td>
                                        <td>{{ $order->customer_name }}</td>
                                        <td>{{ $order->customer_phone }}</td>
                                        <td>{{ $order->customer_address }}</td>
                                        <td>€{{ $order->amount }}</td>
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
@endpush
