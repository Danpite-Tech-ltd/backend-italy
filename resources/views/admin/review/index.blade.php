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
                        <h4 class="mb-0 card-title">Review List</h4>
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
                                        <td>{{ $review->product->name ?? "" }}</td>

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
                                                <span class="badge bg-success">Approved</span>
                                        </td>

                                        <td>
                                            <a href="" class="btn btn-sm btn-primary">
                                                Edit
                                            </a>

                                            <a href="" class="btn btn-sm btn-danger">
                                                Delete
                                            </a>
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
@endpush
