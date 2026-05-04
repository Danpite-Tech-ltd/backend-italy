@extends('frontend.content.dashboard.layout.app')

@push('css')

    <style>
        a {
            text-decoration: none;
            font-weight: 600;
        }
    </style>
@endpush


@section('content')

    <div class="main-content">
        <!-- Content Header -->
        <div class="content-header">
            <h2 class="mb-0">Withdraw/Cash Out History</h2>
            {{--            <p class="mb-0">Your order list items</p>--}}
        </div>

        <!-- Main Content Area -->
        <div class="p-4">
            <div class="section-content">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="profile-info-card">
                            {{--                            <h5 class="mb-3">Personal Information</h5>--}}
                            <form id="profileForm" class="text-center" method="POST"
                                  action="{{ route('withdrawal-request') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mb-3 mx-auto">
                                        <label class="form-label">Account Balance</label>
                                        <input type="text" class="form-control text-center" name="account_balance"
                                               value="{{ $affiliate->account_balance ?? 0 }}" readonly>
                                    </div>

                                    <div class="col-md-6 mb-3 mx-auto">
                                        <label class="form-label">Amount *</label>
                                        <input type="number" class="form-control text-center" id="amount" name="amount"
                                               required>
                                        @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3 mx-auto">
                                        <label class="form-label">Payment Method *</label>
                                        <select class="form-control text-center" id="payment_method"
                                                name="payment_method" required>
                                            <option value="bank" selected="">Bank</option>
                                            <option value="bkash">Bkash</option>
                                            <option value="nagad">Nagad</option>
                                            <option value="rocket">Rocket</option>
                                            <option value="upay">Upay</option>
                                            <option value="cash">Cash</option>
                                        </select>
                                        @error('payment_method')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror

                                    </div>


                                    <div class="col-12 mb-3">
                                        <label class="form-label">Other Payment info</label>
                                        <textarea class="form-control text-center" name="payment_details"
                                                  id="payment_details"></textarea>
                                    </div>

                                    <div class="edit-actions">
                                        <button type="submit" class="btn btn-primary save-btn me-2">
                                            <i class="bi bi-check2 me-2"></i>Request Withdraw
                                        </button>
                                        <a href="{{ route('dashboard') }}" class="btn btn-secondary cancel-btn"
                                           id="cancelEditBtn">
                                            <i class="bi bi-x me-2"></i>Cancel
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')

@endsection

