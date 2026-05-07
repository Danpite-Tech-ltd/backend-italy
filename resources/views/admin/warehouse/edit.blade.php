@extends('admin.layout.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Warehouse</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.warehouse.update', $warehouse->id) }}">
                            @csrf
                            @method('PUT')

                            <!-- Warehouse Name Field -->
                            <div class="form-group">
                                <label for="warehouse_name">Warehouse Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $warehouse->name }}"
                                    placeholder="Enter Warehouse Name" required>
                            </div>

                            <div class="form-group">
                                <label for="warehouse_name">Code</label>
                                <input type="text" class="form-control" id="code" name="code" value="{{ $warehouse->code }}"
                                    placeholder="Enter Warehouse Code" required>
                            </div>

                            <div class="form-group">
                                <label for="warehouse_phone">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ $warehouse->phone }}"
                                    placeholder="Enter Warehouse Phone">
                            </div>
                            <div class="form-group">
                                <label for="warehouse_email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $warehouse->email }}"
                                    placeholder="Enter Warehouse Email">
                            </div>
                            <div class="form-group">
                                <label for="warehouse_address">Address</label>
                                <textarea class="form-control" id="address" name="address"
                                    placeholder="Enter Warehouse Address">{{ $warehouse->address }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Warehouse</button>



                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
