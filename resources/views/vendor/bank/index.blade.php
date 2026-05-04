@extends('vendor.layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Bank Setup | {{ $bankSetup->vendor->email ?? 'N/A' }}</h4>
                    <p class="card-description">
                        Set your bank details for withdrawls
                    </p>
                    <form class="forms-sample" method="POST" action="{{ route('vendor.bank.update', $bankSetup->id) }}">
                        @csrf

                        @method('PUT')


                        <div class="form-group">
                            <label for="bank_name">Bank Name</label>
                            <input type="text" class="form-control" id="bank_name" name="bank_name"
                                placeholder="Enter Bank Name" value="{{ $bankSetup->bank_name ?? '' }}" required>
                        </div>

                        <div class="form-group">
                            <label for="branch_name">Branch Name</label>
                            <input type="text" class="form-control" id="branch_name" name="branch_name"
                                placeholder="Enter Branch Name" value="{{ $bankSetup->branch_name ?? '' }}" required>
                        </div>

                         <div class="form-group">
                            <label for="account_name">Account Name</label>
                            <input type="text" class="form-control" id="account_name" name="account_name"
                                placeholder="Enter Account Name" value="{{ $bankSetup->account_name ?? '' }}" required>
                        </div>

                        <div class="form-group">
                            <label for="account_number">Account Number</label>
                            <input type="text" class="form-control" id="account_number" name="account_number"
                                placeholder="Enter Account Number" value="{{ $bankSetup->account_number ?? '' }}" required>
                        </div>

                        <div class="form-group">
                            <label for="routing_number">Routing Number</label>
                            <input type="text" class="form-control" id="routing_number" name="routing_number"
                                placeholder="Enter Routing Number" value="{{ $bankSetup->routing_number ?? '' }}" required>
                        </div>

                        <div class="form-group">
                            <label for="iban_number">Iban Number</label>
                            <input type="text" class="form-control" id="iban_number" name="iban_number"
                                placeholder="Enter Iban Number" value="{{ $bankSetup->iban_number ?? '' }}" required>
                        </div>

                        <div class="form-group">
                            <label for="swift_code">Swift Code</label>
                            <input type="text" class="form-control" id="swift_code" name="swift_code"
                                placeholder="Enter Swift Code" value="{{ $bankSetup->swift_code ?? '' }}" required>
                        </div>

                        <div class="form-group">
                            <label for="branch_city">Branch City</label>
                            <input type="text" class="form-control" id="branch_city" name="branch_city"
                                placeholder="Enter Branch City" value="{{ $bankSetup->branch_city ?? '' }}" required>
                        </div>

                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" id="country" name="country"
                                placeholder="Enter Country" value="{{ $bankSetup->country ?? '' }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Update Bank Details</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
