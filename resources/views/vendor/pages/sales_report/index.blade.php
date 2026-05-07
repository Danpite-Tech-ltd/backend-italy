@extends('vendor.layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush


@section('content')
    <div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-body">
                    <div class="mb-2 row">
                        <div class="col-lg-12">
                            <div class="form-row">
                                <div class="p-2 form-group col-md-1 d-flex align-items-end">
                                    <button id="allOrdersBtn" class="btn btn-light w-100">All Orders</button>
                                </div>

                                <div class="p-2 form-group col-md-2">
                                    <label for="inputCity" class="col-form-label">Start Date</label>
                                    <input type="text" class="form-control datepicker flatpickr-input active"
                                        id="start_date" value="{{ today() }}" placeholder="Select Date" readonly="readonly">
                                </div>

                                <div class="p-2 form-group col-md-2">
                                    <label for="inputCity" class="col-form-label">End Date</label>
                                    <input type="text" class="form-control datepicker flatpickr-input" id="end_date"
                                        value="{{ today() }}" placeholder="Select Date" readonly="readonly">
                                </div>

                                <div class="p-2 form-group col-md-2">
                                    <label for="inputState" class="col-form-label">Select Status</label>

                                    <select id="status_id" class="form-control">
                                        <option selected value="all">All</option>
                                        @forelse($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->status_name ?? '' }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table mb-0 w-100 dataTable no-footer dtr-inline table-striped" id="adminTable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Invoice ID</th>
                                    <th>Customer info</th>
                                    <th>Products</th>
                                    <th>Total</th>
                                    <!-- <th>Delivery Charge</th>
                                    <th>Discount</th>
                                    <th>Courier</th>
                                    <th>User</th> -->
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>

    {{-- Table Ends--}}

@endsection


@push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>
    {{--
    <script src="{{asset('backend')}}/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>--}}

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>

    <!-- Buttons Export (PDF/Print) -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <!-- PDFMake (required for PDF export) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        $(document).ready(function () {

            setTimeout(() => {
                $('#allOrdersBtn').trigger('click');
            }, 300);
            // Flatpickr
            $(".datepicker").flatpickr();

            let adminTable = $('#adminTable').DataTable({
                dom: '<"row mb-3"' +
                    '<"col-md-6 d-flex align-items-center mb-2 mb-md-0"l>' +
                    '<"col-md-6 d-flex flex-wrap justify-content-md-end gap-2"Bf>' +
                    '>' +
                    '<"row"<"col-12"tr>>' +
                    '<"row mt-3"' +
                    '<"col-md-5"i>' +
                    '<"col-md-7"p>' +
                    '>',
                buttons: [
                    { extend: 'print', text: 'Print Table', className: 'btn btn-success btn-sm' },
                    { extend: 'pdfHtml5', text: 'Download PDF', className: 'btn btn-danger btn-sm' },
                    { extend: 'csv', text: 'CSV Export', className: 'btn btn-info btn-sm' },
                    { extend: 'excel', text: 'Excel Export', className: 'btn btn-success btn-sm' },
                ],
                order: [[0, 'asc']],
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('vendor.sales-reports.index') }}",
                    data: function (d) {
                        // Only send filter=all if allOrdersBtn was clicked
                        if ($('#allOrdersBtn').data('show-all') === true) {
                            d.filter = 'all';
                        } else {
                            d.start_date = $('#start_date').val();
                            d.end_date = $('#end_date').val();
                            // d.courier_id = $('#courier_id').val();
                            // d.admin_id = $('#user_id').val();
                            d.status_id = $('#status_id').val();
                        }
                    }
                },
                columns: [
                    { data: 'order_date', className: 'text-center', width: '10%' },
                    { data: 'invoiceID' },
                    {
                        data: 'customer',
                        render: function (data) {
                            return `${data.name}<br><small>${data.phone}</small>`;
                        }
                    },
                    { data: 'product', width: '15%' },
                    { data: 'total' },
                    // { data: 'delivery_charge' },
                    // { data: 'discount_charge' },
                    // { data: 'courier.type' },
                    // { data: 'admin.name' },
                    { data: 'status' },
                ]
            });

            // 🔁 Reload table when filters change
            $('#start_date, #end_date, #status_id').on('change', function () {
                $('#allOrdersBtn').data('show-all', false); // reset flag
                adminTable.ajax.reload();
            });

            // 🆕 Show All Orders Button
            $('#allOrdersBtn').on('click', function () {
                $(this).data('show-all', true);
                adminTable.ajax.reload();
            });
        });
    </script>
@endpush