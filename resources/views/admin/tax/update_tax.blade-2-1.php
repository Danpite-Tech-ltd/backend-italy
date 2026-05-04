@extends('admin.layout.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Update Tax Settings</div>

                    <div class="card-body">
                        <form method="POST" action="">
                            @csrf

                            <!-- Tax Rate Field -->
                            <div class="form-group">
                                <label for="tax_rate">Tax Rate (%)</label>
                                <input type="number" step="0.01" class="form-control" id="tax_rate" name="tax_rate"
                                    placeholder="Enter Tax Rate" required>
                            </div>
                            <!-- Tax Type Field -->
                            <div class="form-group">
                                <label for="tax_type">Tax Type</label>
                                <select class="form-control" id="tax_type" name="tax_type" required>
                                    <option value="percentage">Percentage</option>
                                    <option value="fixed">Fixed Amount</option>
                                </select>
                            </div>
                            <!-- Active Status Field -->
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" checked>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Tax Settings</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
