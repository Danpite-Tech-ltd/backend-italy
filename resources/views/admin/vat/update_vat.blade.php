@extends('admin.layout.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Update VAT Settings</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.vat.update', $vat->id) }}">
                            @csrf

                            <!-- VAT Rate Field -->
                            <div class="form-group">
                                <label for="vat_rate">VAT Rate (%)</label>
                                <input type="number" step="0.01" class="form-control" id="vat_rate" name="vat_rate"
                                    placeholder="Enter VAT Rate" value="{{ $vat->rate }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update VAT Settings</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
