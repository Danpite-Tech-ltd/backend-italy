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
                        <h4 class="mb-0 card-title">Product Tags List</h4>
                        <button type="button" class="btn btn-md btn-primary" data-bs-toggle="modal"
                            data-bs-target="#createTagModal">
                            <i class="fa-solid fa-plus"></i> Add New Tag
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="productTag">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($tags as $key => $tag)
                                    <tr id="tag-row-{{ $tag->id }}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $tag->name }}</td>

                                        <td>
                                            @if ($tag->status == 1)
                                                <a href="javascript:void(0)"
                                                    class="badge bg-success tag-change-status cursor-pointer"
                                                    data-id="{{ $tag->id }}" title="Click to deactivate">
                                                    <i style="font-size: 17px;" class="fa-solid fa-thumbs-up"></i>
                                                </a>
                                            @else
                                                <a href="javascript:void(0)"
                                                    class="badge bg-danger tag-change-status cursor-pointer"
                                                    data-id="{{ $tag->id }}" title="Click to activate">
                                                    <i style="font-size: 17px;" class="fa-regular fa-thumbs-down"></i>
                                                </a>
                                            @endif
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-sm btn-info tag-edit"
                                                data-id="{{ $tag->id }}" data-bs-toggle="modal"
                                                data-bs-target="#editTagModal">
                                                <i class="fa-solid fa-pencil"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger tag-delete"
                                                data-id="{{ $tag->id }}">
                                                <i class="fa-solid fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
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

    {{-- Create Tag Modal --}}
    <div class="modal fade" id="createTagModal" tabindex="-1" aria-labelledby="createTagModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTagModalLabel">Create New Product Tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createTagForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tagName" class="form-label">Tag Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tagName" name="name"
                                placeholder="Enter tag name" required>
                            <div class="invalid-feedback" id="tagNameError"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span id="createBtnText">Create Tag</span>
                            <span id="createBtnSpinner" class="spinner-border spinner-border-sm ms-2" role="status"
                                aria-hidden="true" style="display: none;"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Tag Modal --}}
    <div class="modal fade" id="editTagModal" tabindex="-1" aria-labelledby="editTagModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTagModalLabel">Edit Product Tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editTagForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editTagId" name="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editTagName" class="form-label">Tag Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editTagName" name="name"
                                placeholder="Enter tag name" required>
                            <div class="invalid-feedback" id="editTagNameError"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span id="editBtnText">Update Tag</span>
                            <span id="editBtnSpinner" class="spinner-border spinner-border-sm ms-2" role="status"
                                aria-hidden="true" style="display: none;"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables Core -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#productTag').DataTable({
                responsive: true,
                pageLength: 10,
                ordering: true,
                searching: true,
                lengthMenu: [10, 25, 50, 100]
            });
        });
    </script>

    {{-- Create Tag AJAX --}}
    <script>
        $('#createTagForm').on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize();
            let btn = $(this).find('button[type="submit"]');

            // Clear previous errors
            $('.invalid-feedback').html('');
            $('#tagName').removeClass('is-invalid');

            // Show loading state
            $('#createBtnSpinner').show();
            $('#createBtnText').text('Creating...');
            btn.prop('disabled', true);

            $.ajax({
                url: "{{ route('admin.product_tag.store') }}",
                type: 'POST',
                data: formData,
                success: function(res) {

                    if (res.status === 'success') {

                        $('#createBtnSpinner').hide();
                        $('#createBtnText').text('Create Tag');
                        btn.prop('disabled', false);

                        $('#createTagForm')[0].reset();

                        // Close modal
                        $('#createTagModal').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res.message || 'Tag created successfully',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    // Hide loading state
                    $('#createBtnSpinner').hide();
                    $('#createBtnText').text('Create Tag');
                    btn.prop('disabled', false);

                    if (xhr.status === 422) {
                        // Validation errors
                        let errors = xhr.responseJSON.errors;
                        if (errors.name) {
                            $('#tagName').addClass('is-invalid');
                            $('#tagNameError').html(errors.name[0]);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Something went wrong'
                        });
                    }
                }
            });
        });
    </script>

    {{-- Edit Tag AJAX (Load data) --}}
    <script>
        $(document).on('click', '.tag-edit', function(e) {
            e.preventDefault();
            let id = $(this).data('id');

            $.ajax({
                url: "{{ url('admin/product-tags') }}" + "/" + id + "/edit",
                type: 'GET',
                success: function(res) {
                    if (res.status === 'success') {
                        $('#editTagId').val(res.data.id);
                        $('#editTagName').val(res.data.name);

                        // Clear previous errors
                        $('.invalid-feedback').html('');
                        $('#editTagName').removeClass('is-invalid');
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Could not load tag data'
                    });
                }
            });
        });
    </script>

    {{-- Update Tag AJAX --}}
    <script>
        $('#editTagForm').on('submit', function(e) {
            e.preventDefault();

            let id = $('#editTagId').val();
            let formData = $(this).serialize();
            let btn = $(this).find('button[type="submit"]');

            // Clear previous errors
            $('.invalid-feedback').html('');
            $('#editTagName').removeClass('is-invalid');

            // Show loading state
            $('#editBtnSpinner').show();
            $('#editBtnText').text('Updating...');
            btn.prop('disabled', true);

            $.ajax({
                url: "{{ url('admin/product-tags') }}" + "/" + id,
                type: 'PUT',
                data: formData,
                success: function(res) {
                    if (res.status === 'success') {
                        // Hide loading state
                        $('#editBtnSpinner').hide();
                        $('#editBtnText').text('Update Tag');
                        btn.prop('disabled', false);

                        // Close modal
                        $('#createTagModal').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res.message || 'Tag Updated successfully',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    // Hide loading state
                    $('#editBtnSpinner').hide();
                    $('#editBtnText').text('Update Tag');
                    btn.prop('disabled', false);

                    if (xhr.status === 422) {
                        // Validation errors
                        let errors = xhr.responseJSON.errors;
                        if (errors.name) {
                            $('#editTagName').addClass('is-invalid');
                            $('#editTagNameError').html(errors.name[0]);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Something went wrong'
                        });
                    }
                }
            });
        });
    </script>

    {{-- Delete Tag AJAX --}}
    <script>
        $(document).on('click', '.tag-delete', function(e) {
            e.preventDefault();
            var btn = $(this);
            var id = btn.data('id');

            Swal.fire({
                title: 'Delete this tag?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/product-tags') }}" + "/" + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            if (res.status === 'success') {
                                btn.closest('tr').fadeOut(300, function() {
                                    $(this).remove();
                                });
                                Swal.fire('Deleted', res.message ||
                                    'Tag deleted successfully',
                                    'success');
                            } else {
                                Swal.fire('Error', res.message ||
                                    'Could not delete', 'error');
                            }
                        },
                        error: function(xhr) {
                            var msg = 'Something went wrong';
                            if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr
                                .responseJSON.message;
                            Swal.fire('Error', msg, 'error');
                        }
                    });
                }
            });
        });
    </script>

    {{-- Change Status AJAX --}}
    <script>
        $(document).on('click', '.tag-change-status', function(e) {
            e.preventDefault();
            let btn = $(this);
            let id = btn.data('id');

            $.ajax({
                url: "{{ route('admin.product_tag.change-status') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function(res) {
                    if (res.status === 'success') {
                        // Update badge
                        btn.removeClass('bg-success bg-danger');
                        btn.addClass(res.badgeClass);
                        btn.html(res.icon);

                        // Update title
                        if (res.new_status == 1) {
                            btn.attr('title', 'Click to deactivate');
                        } else {
                            btn.attr('title', 'Click to activate');
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res.message || 'Status changed successfully',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Could not change status'
                    });
                }
            });
        });
    </script>
@endpush
