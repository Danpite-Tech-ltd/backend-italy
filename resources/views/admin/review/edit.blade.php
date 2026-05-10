@extends('admin.layout.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">

                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 card-title">Edit Review List</h4>
                        {{-- <a href="{{ route('admin.vendor.create') }}" class="btn btn-md btn-secondary">
                                Review create
                            </a> --}}
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('admin.review.update', $review->id) }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Name</label>
                                <input class="form-control" name="name" readonly value="{{ $review->name }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input class="form-control" name="phone" readonly value="{{ $review->phone }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Email</label>
                                <input class="form-control" name="email" readonly value="{{ $review->email }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Image : </label>
                                <img src="{{ asset($review->image) }}" readonly height="120" width="120">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Ratting</label>
                                <input type="number" min="1" max="5" readonly class="form-control" name="ratting"
                                    value="{{ $review->ratting }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Message</label>
                                <textarea class="form-control" name="review" readonly rows="4">{{ $review->review }}</textarea>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Reply Message</label>

                                <textarea class="form-control" name="reply_message" rows="4">{{ $review->reply_message }}</textarea>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="pending" @if ($review->status == 'pending') selected @endif>Pending
                                    </option>
                                    <option value="approve" @if ($review->status == 'approve') selected @endif>Approve
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3 col-12">
                                <button type="submit" style="padding: 10px;width:100%;background:red; color:white;">Update</button>
                            </div>
                        </div>

                    </form>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
@endsection
