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
                        <h4 class="mb-0 card-title">Pending Review List</h4>
                        {{-- <a href="{{ route('admin.vendor.create') }}" class="btn btn-md btn-secondary">
                                Review create
                            </a> --}}
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="reviewTable">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Product Name</th>
                                    <th>Rating</th>
                                    <th>Message</th>
                                    <th>Image</th>
                                    <th>Reply Message</th>
                                    <th>Status</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($reviews as $key => $review)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $review->name }}</td>
                                        <td>{{ $review->product->name }}</td>

                                        <td>
                                            <span class="badge bg-warning text-dark">
                                                {{ $review->ratting }}
                                            </span>
                                        </td>

                                        <td>{{ Str::limit($review->review, 50) }}</td>

                                        <td>
                                            <img src="{{ asset($review->image) }}" width="60" height="60"
                                                style="object-fit:cover;border-radius:6px;">
                                        </td>
                                        <td>{{ $review->reply_message }}</td>
                                        <td>
                                            <a href="javascript:void(0)" class="badge bg-danger review-change-status"
                                                data-id="{{ $review->id }}">
                                                <i style="font-size: 17px;" class="fa-regular fa-thumbs-down"></i>
                                            </a>
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.review.edit', $review->id) }}" class="btn btn-sm btn-success">
                                                Edit
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger review-delete"
                                                data-id="{{ $review->id }}">
                                                Delete
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

    {{-- Table Ends --}}
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
        $(document).ready(function() {
            $('#reviewTable').DataTable({
                responsive: true,
                pageLength: 10,
                ordering: true,
                searching: true,
                lengthMenu: [10, 25, 50, 100]
            });
        });
    </script>
    <script>
        $(document).on('click', '.review-change-status', function(e) {
            e.preventDefault();
            var btn = $(this);
            var id = btn.data('id');

            Swal.fire({
                title: 'Approve this review?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, approve'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.review.changeStatus') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id
                        },
                        success: function(res) {
                            if (res.status === 'success') {
                                btn.removeClass('bg-danger').addClass('bg-success').text(
                                    'Approved');
                                Swal.fire('Approved', res.message || 'Review approved',
                                    'success');
                                window.location.reload();
                            } else {
                                Swal.fire('Error', res.message || 'Could not approve', 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'Something went wrong', 'error');
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.review-delete', function(e) {
            e.preventDefault();
            var btn = $(this);
            var id = btn.data('id');

            Swal.fire({
                title: 'Delete this review?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.review.delete') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            review_id: id
                        },
                        success: function(res) {
                            if (res.status === 'success') {
                                btn.closest('tr').fadeOut(300, function() {
                                    $(this).remove();
                                });
                                Swal.fire('Deleted', res.message || 'Review deleted',
                                'success');
                            } else {
                                Swal.fire('Error', res.message || 'Could not delete', 'error');
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
@endpush
