@extends('admin.layout.app')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">

@endpush


@section('content')

    {{--    <div class="row">--}}
    {{--        <div class="col-12">--}}
    {{--            <div class="page-title-box d-sm-flex align-items-center justify-content-end">--}}
    {{--                <h4 class="mb-sm-0 font-size-18">Admins</h4>--}}

    {{--                <div class="page-title-right">--}}
    {{--                    <ol class="breadcrumb m-0">--}}
    {{--                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>--}}
    {{--                        <li class="breadcrumb-item active">Admins</li>--}}
    {{--                    </ol>--}}
    {{--                </div>--}}

    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    {{-- Table Starts--}}

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">

                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Product List</h4>
                        @can('Create Product')
                            <a href="{{ route('admin.product.create') }}" class="btn btn-md btn-secondary">
                                Create Product
                            </a>
                        @endcan
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0 w-100 dataTable no-footer dtr-inline table-striped"
                               id="adminTable">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Vendor</th>
                                <th>Branch</th>
                                <th>Warehouse</th>
                                <th>Price</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Actions</th>

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

    {{--    Table Ends--}}

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

            var token = $("input[name='_token']").val();
            let baseAssetUrl = "{{ asset('') }}";
            //Show Data through Datatable
            let adminTable = $('#adminTable').DataTable({
                autoWidth: false,

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
                ajax: "{{route('admin.pendingProducts')}}",
                // pageLength: 30,

                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: '15%'
                    },
                    {
                        data: 'thumbnail_img',
                        name: 'thumbnail_img',
                        render: function (data, type, row) {
                            return '<img src="' + baseAssetUrl + row.thumbnail_img + '" width="200" height="200" alt="Image">';
                        },
                        width: '10%'


                    },
                    {
                        data: 'name',
                        name: 'name',
                        width: '20%'
                    },
                    {
                        data: 'category.name',
                        name: 'category.name',
                        width: '10%',
                        render: function (data, type, row) {
                            return `<span class="badge bg-info"> ${data} </span>`
                        },


                    },
                    {
                        data: 'vendor.company_name',
                        name: 'vendor.company_name',
                        width: '10%',
                        render: function (data, type, row) {
                            return `<span class="badge bg-info"> ${data} </span>`
                        },


                    },
                    {
                        data: 'branch.name',
                        name: 'branch.name',
                        width: '10%',
                        render: function (data, type, row) {
                            return `<span class="badge bg-info"> ${data} </span>`
                        },


                    },
                     {
                        data: 'warehouse.name',
                        name: 'warehouse.name',
                        width: '10%',
                        render: function (data, type, row) {
                            return `<span class="badge bg-info"> ${data} </span>`
                        },


                    },
                    {
                        data: 'product_price',
                        width: '10%',
                        searchable: false,
                        orderable: false
                    },

                    {
                        data: 'type.name',
                        render: function (data, type, row) {
                            return `<span class="badge bg-primary"> ${data} </span>`
                        },
                        width: '10%'
                    },

                    {
                        data: 'status',
                        width: '10%'


                    },

                    {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        width: '15%'
                    },

                ]
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

                                url: "{{ url('admin/products') }}/" + id,
                                data: {
                                    '_token': token
                                },
                                success: function (res) {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Product has been deleted.",
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

            // Change Admin Status
            $(document).on('click', '#adminStatus', function () {
                let id = $(this).data('id');
                let status = $(this).data('status')
                console.log(id + status)
                $.ajax(
                    {
                        type: 'post',
                        url: "{{route('admin.product.status')}}",
                        data: {
                            '_token': token,
                            id: id,
                            status: status

                        },
                        success: function (res) {
                            adminTable.ajax.reload();

                            if (res.status == 1) {

                                swal.fire(
                                    {
                                        title: 'Status Changed to Active',
                                        icon: 'success'
                                    })
                            } else {
                                swal.fire(
                                    {
                                        title: 'Status Changed to Inactive',
                                        icon: 'success'
                                    })

                            }
                        },
                        error: function (err) {
                            console.log(err)
                        }
                    }
                )
            })
        });
    </script>
@endpush
