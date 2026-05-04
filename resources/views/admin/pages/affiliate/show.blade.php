@extends('admin.layout.app')

@push('css')

@endpush


@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- Profile Card -->
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-body p-4">

                        <!-- Header -->
                        <div class="d-flex align-items-center mb-4">
                            <div class="me-3">
                                @if($user->profile_image)
                                    <img src="{{ asset($user->profile_image) }}"
                                         alt="Profile Image"
                                         class="rounded-circle"
                                         width="100" height="100">
                                @else
                                    <img src="{{ asset('images/default-profile.png') }}"
                                         alt="Default Image"
                                         class="rounded-circle"
                                         width="100" height="100">
                                @endif
                            </div>
                            <div>
                                <h3 class="mb-1">{{ $user->name }}</h3>
                                <p class="text-muted mb-0">{{ $user->email }}</p>
                            </div>
                        </div>

                        <!-- Information Section -->
                        <h5 class="text-primary mb-3">Basic Information</h5>
                        <ul class="list-group mb-4">
                            <li class="list-group-item">
                                <i class="bi bi-person-circle me-2"></i>
                                <strong>Name:</strong> {{ $user->name }}
                            </li>

                            <li class="list-group-item">
                                <i class="bi bi-envelope me-2"></i>
                                <strong>Email:</strong> {{ $user->email ?? 'N/A' }}
                            </li>

                            <li class="list-group-item">
                                <i class="bi bi-envelope me-2"></i>
                                <strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}
                            </li>

                            <li class="list-group-item">
                                <i class="bi bi-envelope me-2"></i>
                                <strong>Address:</strong> {{ $user->address ?? 'N/A' }}
                            </li>
                        </ul>

                        <!-- Balance Section -->
                        <h5 class="text-success mb-3">Account Balances</h5>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between">
                                <span><i class="bi bi-wallet2 me-2"></i> Account Balance</span>
                                <strong>{{ number_format($user->account_balance, 2) }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span><i class="bi bi-cash-coin me-2"></i> Withdraw Balance</span>
                                <strong>{{ number_format($user->withdrawal_balance, 2) }}</strong>
                            </li>

                        </ul>

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection


@push('js')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- SweetAlert2 (optional, fine anywhere after jQuery) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endpush
