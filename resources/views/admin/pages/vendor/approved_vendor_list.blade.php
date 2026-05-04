@extends('admin.layout.app')

@push('css')
    <!-- DataTables Bootstrap 5 CSS -->
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

@endpush


@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">

                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 card-title"> Vendors Approved List</h4>
                        <a href="{{ route('admin.vendor.create') }}" class="btn btn-md btn-secondary">
                            Create Vendor
                        </a>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0 nowrap w-100 dataTable no-footer dtr-inline table-striped"
                            id="vendorTable">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Commission</th>
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

    {{-- Table Ends--}}

@endsection


@push('js')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    <!-- SweetAlert2 (optional, fine anywhere after jQuery) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables Core (1.13.8) -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>



    <script>

        $(document).ready(function () {

            var token = $("input[name='_token']").val();

            //Show Data through Datatable
            let vendorTable = $('#vendorTable').DataTable({


                order: [
                    [0, 'asc']
                ],
                processing: true,
                serverSide: true,
                ajax: "{{route('admin.approved.vendor.list')}}",
                // pageLength: 30,

                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false


                    },
                    {
                        data: 'name',
                        name: 'name',

                    },
                    {
                        data: 'email',
                        name: 'email',

                    },
                    {
                        data: 'commission_value',
                        name: 'commission_value',

                    },
                    {
                        data: 'status',
                        orderable: false,
                    },

                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },

                ]
            });
            // edit vendor
            $(document).on('click', '#editVendorBtn', function () {

                let id = $(this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            url: "{{ url('admin/approved/vendors/edit') }}/" + id,
                            type: 'GET',
                            success: function (res) {
                                Swal.fire("Deleted!", res.message, "success");
                                vendorTable.ajax.reload(null, false);
                            },
                            error: function (err) {
                                console.log(err);
                                Swal.fire("Error!", "Something went wrong.", "error");
                            }
                        });

                    } else {
                        Swal.fire("Your data is safe!");
                    }

                });

            });

            // Status Change
            $(document).on('click', '.vendorStatus', function () {

                let id = $(this).data('id');
                let status = $(this).data('status');

                $.ajax({
                    type: 'post',
                    url: "{{route('admin.approved.vendor.status')}}",
                    data: {
                        _token: token,
                        id: id,
                        status: status
                    },
                    success: function (res) {
                        vendorTable.ajax.reload();

                        Swal.fire({
                            title: res.status == 'approved' ? 'Status Changed to Active' : 'Status Changed to Inactive',
                            icon: 'success'
                        });
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            });


        });
    </script>
@endpush
