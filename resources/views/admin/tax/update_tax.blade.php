@extends('admin.layout.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Update Tax Settings</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.tax.update', $tax->id) }}">
                            @csrf

                            <!-- Tax Rate Field -->
                            <div class="form-group">
                                <label for="tax_rate">Tax Rate (%)</label>
                                <input type="number" step="0.01" class="form-control" id="tax_rate" name="tax_rate"
                                    placeholder="Enter Tax Rate" value="{{ $tax->rate }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Tax Settings</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
