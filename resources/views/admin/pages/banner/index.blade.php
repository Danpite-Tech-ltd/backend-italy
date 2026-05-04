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
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">

                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 card-title">Banner List</h4>
                        @can('Create Banner')
                            <button class="btn btn-md btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#createAdminModal">
                                Create Banner
                            </button>
                        @endcan
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0 nowrap w-100 dataTable no-footer dtr-inline table-striped"
                               id="adminTable">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Image</th>
                                <th>Banner Title</th>
                                <th>Type</th>
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

    {{--    Create Admin Modal--}}
    <div class="modal fade" id="createAdminModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="form" id="createAdmin">
                        @csrf

                        <div class="mb-3">
                            <label for="title_1" class="col-form-label">Title</label>
                            <input type="text" class="form-control" name="title_1" required>
                        </div>

                        {{--                        <div class="mb-3">--}}
                        {{--                            <label for="text" class="col-form-label">Text</label>--}}
                        {{--                            <input type="text" class="form-control" name="text" required>--}}
                        {{--                        </div>--}}

                        {{--                        <div class="mb-3">--}}
                        {{--                            <label for="btn_name" class="col-form-label">Button Name</label>--}}
                        {{--                            <input type="text" class="form-control" name="btn_name" required>--}}
                        {{--                        </div>--}}

                        {{--                        <div class="mb-3">--}}
                        {{--                            <label for="btn_link" class="col-form-label">Button Link</label>--}}
                        {{--                            <input type="text" class="form-control" name="btn_link" required>--}}
                        {{--                        </div>--}}

                        <div class="mb-3">
                            <label for="type" class="col-form-label">Type</label>
                            <select name="type" class="form-control">
                                <option value="normal">Normal</option>
                                <option value="offer">Offer</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="col-form-label">banner Image</label>
                            <input type="file" class="form-control" name="image" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="col-form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--    Edit Categories Modal--}}
    <div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="form2" id="editAdmin" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="title_1" class="col-form-label">Title</label>
                            <input type="text" class="form-control" id="title_1" name="title_1" required>
                        </div>

                        {{--                        <div class="mb-3">--}}
                        {{--                            <label for="text" class="col-form-label">Text</label>--}}
                        {{--                            <input type="text" class="form-control" id="text" name="text" required>--}}
                        {{--                        </div>--}}

                        {{--                        <div class="mb-3">--}}
                        {{--                            <label for="btn_name" class="col-form-label">Button Name</label>--}}
                        {{--                            <input type="text" class="form-control" id="btn_name" name="btn_name" required>--}}
                        {{--                        </div>--}}

                        {{--                        <div class="mb-3">--}}
                        {{--                            <label for="btn_link" class="col-form-label">Button Link</label>--}}
                        {{--                            <input type="text" id="btn_link" class="form-control" name="btn_link" required>--}}
                        {{--                        </div>--}}

                        <div class="mb-3">
                            <label for="type" class="col-form-label">Type</label>
                            <select name="type" id="type" class="form-control">
                                <option value="normal">Normal</option>
                                <option value="offer">Offer</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="col-form-label">banner Image</label>
                            <input type="file" class="form-control" name="image">

                            <div id="imgPrev">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="col-form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>


                        <input id="id" type="number" hidden>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    </form>
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
                ajax: "{{route('admin.banner.index')}}",
                // pageLength: 30,

                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false


                    },
                    {
                        data: 'image',
                        name: 'image',
                        render: function (data, type, row) {
                            return '<img src="' + baseAssetUrl + row.image + '" width="200" height="200" alt="Image">';
                        }


                    },
                    {
                        data: 'title_1',
                        name: 'title_1',

                    },

                    {
                        data: 'type',
                        render: function (data, type, row) {
                            return '<span class="badge bg-success">' + data + '</span>';
                        }
                    },


                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },

                ]
            });


            // Create Admin
            $('#createAdmin').submit(function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.banner.store') }}",
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        if (res.status === 'success') {
                            $('#createAdminModal').modal('hide');
                            $('#createAdmin')[0].reset();
                            adminTable.ajax.reload()
                            swal.fire({
                                title: "Success",
                                text: "Banner Created !",
                                icon: "success"
                            })


                        }
                    },
                    error: function (err) {
                        console.error('Error:', err);
                        swal.fire({
                            title: "Failed",
                            text: "Something Went Wrong !",
                            icon: "error"
                        })
                        // Optionally, handle error behavior like showing an error message
                    }
                });
            });

            // Edit Admin Data
            $(document).on('click', '.editButton', function () {
                let id = $(this).data('id');
                $('#id').val(id);

                $.ajax(
                    {
                        type: "GET",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ url('admin/banners') }}/" + id + "/edit",
                        data: {
                            id: id
                        },

                        processData: false,  // Prevent jQuery from processing the data
                        contentType: false,  // Prevent jQuery from setting contentType
                        success: function (res) {

                            console.log('success')
                            $('#title_1').val(res.data.title_1);
                            // $('#text').val(res.data.text);
                            // $('#btn_name').val(res.data.btn_name);
                            // $('#btn_link').val(res.data.btn_link);
                            $('#type').val(res.data.type);
                            $('#status').val(res.data.status);

                            $('#imgPrev').empty();
                            $('#imgPrev').append(
                                `<img id="profileImg" src="{{asset('')}}${res.data.image}" width="100px" height="100px">`
                            );

                        },
                        error: function (err) {
                            console.log('failed')
                        }
                    }
                )
            })

            // Update Admin Data
            $('#editAdmin').submit(function (e) {
                e.preventDefault();
                let id = $('#id').val();
                let formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('admin/banners') }}/" + id,
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        if (res.status === 'success') {
                            $('#editAdminModal').modal('hide');
                            $('#editAdmin')[0].reset();
                            adminTable.ajax.reload()
                            swal.fire({
                                title: "Success",
                                text: "Banner Updated !",
                                icon: "success"
                            })


                        }
                    },
                    error: function (err) {
                        console.error('Error:', err);
                        swal.fire({
                            title: "Failed",
                            text: "Something Went Wrong !",
                            icon: "error"
                        })
                        // Optionally, handle error behavior like showing an error message
                    }
                });
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

                                url: "{{ url('admin/banners') }}/" + id,
                                data: {
                                    '_token': token
                                },
                                success: function (res) {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Banner has been deleted.",
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
            {{--$(document).on('click', '#adminStatus', function () {--}}
            {{--    let id = $(this).data('id');--}}
            {{--    let status = $(this).data('status')--}}
            {{--    console.log(id + status)--}}
            {{--    $.ajax(--}}
            {{--        {--}}
            {{--            type: 'post',--}}
            {{--            url: "{{route('admin.banners.status')}}",--}}
            {{--            data: {--}}
            {{--                '_token': token,--}}
            {{--                id: id,--}}
            {{--                status: status--}}

            {{--            },--}}
            {{--            success: function (res) {--}}
            {{--                adminTable.ajax.reload();--}}

            {{--                if (res.status == 1) {--}}

            {{--                    swal.fire(--}}
            {{--                        {--}}
            {{--                            title: 'Status Changed to Active',--}}
            {{--                            icon: 'success'--}}
            {{--                        })--}}
            {{--                } else {--}}
            {{--                    swal.fire(--}}
            {{--                        {--}}
            {{--                            title: 'Status Changed to Inactive',--}}
            {{--                            icon: 'success'--}}
            {{--                        })--}}

            {{--                }--}}
            {{--            },--}}
            {{--            error: function (err) {--}}
            {{--                console.log(err)--}}
            {{--            }--}}
            {{--        }--}}
            {{--    )--}}
            {{--})--}}
        });
    </script>
@endpush
