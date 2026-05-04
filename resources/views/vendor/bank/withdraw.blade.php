
@extends('vendor.layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    {{-- <h4 class="card-title">Withdrawl Request | {{ $vendor->email ?? 'N/A' }}</h4> --}}
                    <h4 class="card-title">Withdrawl Request </h4>
                    <p class="card-description">
                        Request your withdrawl amount
                    </p>
                    <form class="forms-sample" method="POST" action="">
                        @csrf







                        <input type="text" name="vendor_id" value="{{ Auth::guard('vendor')->user()->id }}" hidden>

                        <div class="form-group">
                            <label for="withdraw_amount">Withdraw Amount</label>
                            <input type="number" class="form-control" id="withdraw_amount" name="withdraw_amount"
                                placeholder="Enter Withdraw Amount" required>
                        </div>


                        <button type="submit" class="btn btn-primary mr-2">Submit Withdraw Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
