@extends('vendor.layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">

    <style>
        .table td img {
            width: 60px;
            height: 60px;
            border-radius: 100%;
        }

        .status-card {
            cursor: pointer;
        }
    </style>

@endpush


@section('content')

    {{--    <div class="row">--}}
    {{--        <div class="col-12">--}}
    {{--            <div class="page-title-box d-sm-flex align-items-center justify-content-end">--}}
    {{--                <h4 class="mb-sm-0 font-size-18">Admins</h4>--}}

    {{--                <div class="page-title-right">--}}
    {{--                    <ol class="m-0 breadcrumb">--}}
    {{--                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>--}}
    {{--                        <li class="breadcrumb-item active">Admins</li>--}}
    {{--                    </ol>--}}
    {{--                </div>--}}

    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    {{-- Table Starts--}}
    <div class="row">

        @forelse($statuses as $status)
            <div class="col-xl-3 col-md-6 mb-4 status-card" data-status="{{ $status->id }}"
                 data-status-name="{{ $status->status_name }}">
                <!-- card -->

                <div class="card card-h-100 shadow">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-4 text-center  rounded">
                                <i class="fas fa-cart-plus h2"></i>
                            </div>

                            <div class="col-8">
                                <span
                                    class="text-muted mb-3 lh-1 d-block text-truncate">{{ $status->status_name }}</span>
                                <h4 class="mb-3">
                                    <span class="">{{ $status->orders()->count() ?? 0 }}</span>
                                </h4>
                            </div>
                        </div>

                    </div><!-- end card body -->
                </div>

            </div>
        @empty
        @endforelse

    </div>
    <div class="modal fade" id="pathao" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pathao Courier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.pathao.order-submit') }}" id="pathaoOrderForm" method="post">
                    @csrf
                    <input type="hidden" name="order_ids" id="order_ids">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="pathaostore" class="form-label">Store</label>
                            <select name="pathaostore" id="pathaostore" class="pathaostore form-control" required>
                                <option value="">Select Store...</option>
                                @if(isset($pathaostore['data']['data']))
                                    @foreach($pathaostore['data']['data'] as $key=>$store)
                                        <option value="{{$store['store_id']}}">{{$store['store_name']}}</option>
                                    @endforeach
                                @else
                                @endif
                            </select>
                        </div>
                        <!-- form group end -->
                        <div class="form-group mt-3">
                            <label for="pathaocity" class="form-label">City</label>
                            <select name="pathaocity" id="pathaocity" class="chosen-select pathaocity form-control"
                                    style="width:100%" required>
                                <option value="">Select City...</option>
                                @if(isset($pathaocities['data']['data']))
                                    @foreach($pathaocities['data']['data'] as $key=>$city)
                                        <option value="{{$city['city_id']}}">{{$city['city_name']}}</option>
                                    @endforeach
                                @else
                                @endif
                            </select>

                        </div>
                        <!-- form group end -->
                        <div class="form-group mt-3">
                            <label for="" class="form-label">Zone</label>
                            <select name="pathaozone" id="pathaozone" class="pathaozone chosen-select form-control"
                                    value="{{ old('pathaozone') }}" style="width:100%" required>
                            </select>

                        </div>
                        <!-- form group end -->
                        <div class="form-group mt-3">
                            <label for="" class="form-label">Area</label>
                            <select name="pathaoarea" id="pathaoarea"
                                    class="pathaoarea chosen-select form-control  {{ $errors->has('pathaoarea') ? ' is-invalid' : '' }}"
                                    value="{{ old('pathaoarea') }}" style="width:100%">
                            </select>
                            @if ($errors->has('pathaoarea'))
                                <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('pathaoarea') }}</strong>
              </span>
                            @endif
                        </div>
                        <!-- form group end -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">

                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 card-title"><span id="tableTitle">All</span> Order List </h4>


                        <div class="d-flex gap-3">
                            @isset($steadfastStatus)
                                <a href="javascript:void(0)"
                                   class="btn rounded-pill btn-info steadfast">
                                    <i class="fas fa-truck"></i> Steadfast
                                </a>
                            @endisset

                            @isset($pathaoStatus)
                                <a data-bs-toggle="modal" data-bs-target="#pathao"
                                   class="btn rounded-pill btn-danger multi_order_courier pathao">
                                    <i class="fas fa-truck"></i> Pathao
                                </a>
                            @endisset

                            @can('Create Order')
                                <a class="btn btn-md rounded-pill btn-secondary"
                                   href="{{ route('admin.order.create') }}">
                                    Create Order
                                </a>
                            @endcan
                        </div>


                    </div>

                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0 w-100 dataTable no-footer dtr-inline table-bordered"
                           id="adminTable">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th>Invoice No</th>
                            <th>Customer info</th>
                            <th>Products</th>
                            <th>Total</th>
                            <th>Customer Notes</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            {{--                                <th>Assigned to</th>--}}
                            {{-- <th>Actions</th> --}}
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

@endsection


@push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>
    {{--    <script src="{{asset('backend')}}/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>--}}

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>

    <!-- Buttons Export (PDF/Print) -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <!-- PDFMake (required for PDF export) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script>

        $(document).ready(function () {

            let token = $("input[name='_token']").val();

            let baseAssetUrl = "{{ asset('') }}";

            // Get status from URL query string, default to 'all'
            function getQueryParam(name) {
                let urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(name) || 'all';
            }

            let currentStatus = getQueryParam('status');


            //Show Data through Datatable
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
                    {
                        extend: 'print',
                        text: 'Print Table',
                        className: 'btn btn-success btn-sm'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Download PDF',
                        className: 'btn btn-danger btn-sm'
                    },
                    {extend: 'csv', className: 'btn btn-info btn-sm', text: 'CSV Export'},
                    {extend: 'excel', className: 'btn btn-success btn-sm', text: 'Excel Export'},

                ],

                order: [
                    [0, 'asc']
                ],
                processing: true,
                serverSide: true,
                {{--ajax: "{{url('/vendor/data')}}",--}}
                ajax: "{{ route('vendor.order.index') }}?status=" + currentStatus,
                // pageLength: 30,

                columns: [
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function (data, type, row) {
                            return `<input type="checkbox" class="rowCheckbox" value="${data}">`;
                        },
                        width: '5%'
                    },
                    {
                        data: 'invoice_info',
                        name: 'invoiceID',
                        className: 'text-center align-top',
                        width: '10%'


                    },

                    {
                        data: 'customer_info',
                        name: 'customer.phone',
                        className: 'text-center align-top',
                        orderable: false,
                        width: '15%'


                    },

                    {
                        data: 'product_info',
                        // name: 'orderProducts.product_name',
                        className: 'text-center align-top',
                        orderable: false,
                        width: '20%'
                    },


                    {
                        data: 'total',
                        className: 'text-center align-top fw-bold fs-5',
                        width: '5%'

                    },
                    {
                        data: 'customer_note',
                        className: 'text-center align-top',
                        width: '15%'
                    },
                    {
                        data: 'payment_method',
                        className: 'text-center align-top',
                        width: '10%',
                        render: function (data) {
                       if(data)
                       {
                           return `<span class="badge bg-info">${data}</span>`
                       }
                       else {
                           return `<span class="badge bg-info">COD</span>`
                       }

                        }

                    },
                    {
                        data: 'status_select',
                        className: 'text-center align-top',
                        width: '10%'
                    },

                    // {
                    //     data: 'admin.name',
                    //     name: 'admin.name',
                    //     className: 'text-center align-top'
                    // },

                    // {
                    //     data: 'action',
                    //     orderable: false,
                    //     searchable: false,
                    //     className: 'text-center align-top',
                    //     width: '10%'
                    // },
                ]
            });


            // Update title on page load
            let statusName = $('.status-card[data-status="' + currentStatus + '"]').find('span').text() || 'All Orders';
            $('#tableTitle').text(statusName);


            // Status Change
            $(document).on('click', '.status-card', function () {
                let status = $(this).data('status');
                let statusName = $(this).data('status-name');

                $('#tableTitle').text(statusName);
                // Update the DataTable ajax URL
                adminTable.ajax.url("{{ route('vendor.order.index') }}?status=" + status).load();

                // Update URL without reloading
                let newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + "?status=" + status;
                window.history.pushState({path: newUrl}, '', newUrl);
            });


            // Delete Admin
            $(document).on('click', '#deleteAdminBtn', function () {
                let id = $(this).data('id');

                swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this !",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                })
                    .then((result) => {
                        if (result.isConfirmed) {


                            $.ajax({
                                type: 'DELETE',

                                url: "{{ url('vendor/orders') }}/" + id,
                                data: {
                                    '_token': token
                                },
                                success: function (res) {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Order has been deleted.",
                                        icon: "success"
                                    });

                                    adminTable.ajax.reload();
                                },
                                error: function (err) {
                                    console.log('error')
                                }
                            })

                        } else {
                            swal.fire('Your Data is Safe');
                        }

                    })


            })


            // Change Order Status
            $(document).on('change', '.order-status-change', function () {

                let order_id = $(this).data('id');
                let order_status_id = $(this).val();

                console.log(order_id, order_status_id)
                $.ajax({
                    type: 'POST',

                    url: "{{ route('vendor.order.status-change') }}",
                    data: {
                        order_id: order_id,
                        order_status_id: order_status_id,
                        '_token': token
                    },
                    success: function (res) {

                        toastr.success(res.message);
                        adminTable.ajax.reload();
                    },
                    error: function (err) {
                        console.log('error')
                    }
                })

            });


            //Checkbox
            // Select/Deselect all checkboxes
            $('#selectAll').on('click', function () {
                $('.rowCheckbox').prop('checked', this.checked);
            });

            // If any row unchecked, uncheck the selectAll
            $('#adminTable').on('click', '.rowCheckbox', function () {
                if (!this.checked) {
                    $('#selectAll').prop('checked', false);
                }
                // If all rows checked, tick selectAll
                if ($('.rowCheckbox:checked').length === $('.rowCheckbox').length) {
                    $('#selectAll').prop('checked', true);
                }
            });

            // Example: get all selected IDs
            function getSelectedIds() {
                let ids = [];
                $('.rowCheckbox:checked').each(function () {
                    ids.push($(this).val());
                });

                return ids;
            }


            //steadfast

            //pathao



            //pathao

        });
    </script>
@endpush
