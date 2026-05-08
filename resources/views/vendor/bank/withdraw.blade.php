
@extends('vendor.layouts.master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    {{-- <h4 class="card-title">Withdrawl Request | {{ $vendor->email ?? 'N/A' }}</h4> --}}
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="card-title">Withdrawl Request </h4>
                            <p class="card-description">
                                Request your withdrawl amount
                            </p>
                        </div>
                        <h4 class="card-title">BALANCE: {{ $balance }}</h4>
                    </div>
                    <form class="forms-sample" method="POST" action="{{ route('vendor.bank.withdraw.submit') }}">
                        @csrf


                        <input type="text" name="vendor_id" value="{{ Auth::guard('vendor')->user()->id }}" hidden>

                        <div class="form-group">
                            <label for="amount">Withdraw Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount"
                                placeholder="Enter Withdraw Amount" required>
                        </div>
                        <div class="form-group">
                            <label for="note">Note (optional)</label>
                            <textarea type="text" class="form-control" id="note" name="note"
                                placeholder="Enter Note" rows="4">
                            </textarea>
                        </div>


                        <button type="submit" class="btn btn-primary mr-2">Submit Withdraw Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
