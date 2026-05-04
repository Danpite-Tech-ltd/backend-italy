@extends('admin.layout.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Branch</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.branch.store') }}">
                            @csrf

                            <!-- Branch Name Field -->
                            <div class="form-group">
                                <label for="branch_name">Branch Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Branch Name" required>
                            </div>
                            <div class="form-group">
                                <label for="branch_name">Code</label>
                                <input type="text" class="form-control" id="code" name="code"
                                    placeholder="Enter Branch Code" required>
                            </div>
                            <div class="form-group">
                                <label for="branch_phone">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="Enter Branch Phone">
                            </div>
                            <div class="form-group">
                                <label for="branch_email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter Branch Email">
                            </div>
                            <div class="form-group">
                                <label for="branch_address">Address</label>
                                <textarea class="form-control" id="address" name="address"
                                    placeholder="Enter Branch Address"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Branch</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
