@extends('frontend.content.dashboard.layout.app')


@section('content')

    <div class="main-content">
        <!-- Content Header -->
        <div class="content-header">
            <h2 class="mb-0">Settings</h2>
            <p class="mb-0">Customize your functionality</p>
        </div>


        <!-- Setting Content Area -->
        <div class="p-4">
            <div class="row g-4">
                <!-- Account Settings -->
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-person-circle me-2"></i>Account
                                Settings</h5>
                            <form action="{{ route('user-settings-update') }}" method="POST">
                                @csrf

                                <div class="mb-2">
                                    <input type="text" class="form-control" value="{{ Auth::user()->name ?? '' }}" name="name" placeholder="Full Name" required>
                                    <div class="mt-1">
                                        @error('name')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <input type="email" class="form-control" value="{{ Auth::user()->email ?? '' }}" name="email" placeholder="Enter new email" required>
                                    <div class="mt-1">
                                        @error('email')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-2 position-relative">
                                    <input type="password" class="form-control" id="passwordField" name="password" placeholder="New Password">

                                    <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer" id="togglePassword"></i>

                                    <div class="mt-1">
                                        @error('password')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                                    <div class="mt-1">
                                        @error('password_confirmation')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-sm w-100 mt-2">
                                    <i class="bi bi-check2 me-2"></i>Save Changes
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Notifications -->
{{--                <div class="col-md-6 col-xl-4">--}}
{{--                    <div class="card h-100 shadow-sm">--}}
{{--                        <div class="card-body">--}}
{{--                            <h5 class="card-title"><i class="bi bi-bell me-2"></i>Notifications</h5>--}}
{{--                            <div class="form-check form-switch mb-1">--}}
{{--                                <input class="form-check-input" type="checkbox" id="emailNotifications" checked="">--}}
{{--                                <label class="form-check-label" for="emailNotifications">Email--}}
{{--                                    Notifications</label>--}}
{{--                            </div>--}}
{{--                            <div class="form-check form-switch mb-1">--}}
{{--                                <input class="form-check-input" type="checkbox" id="smsNotifications">--}}
{{--                                <label class="form-check-label" for="smsNotifications">SMS--}}
{{--                                    Notifications</label>--}}
{{--                            </div>--}}
{{--                            <div class="form-check form-switch mb-1">--}}
{{--                                <input class="form-check-input" type="checkbox" id="pushNotifications" checked="">--}}
{{--                                <label class="form-check-label" for="pushNotifications">Push--}}
{{--                                    Notifications</label>--}}
{{--                            </div>--}}
{{--                            <div id="notifMessage" class="small text-muted mt-1"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}


                <!-- Security -->
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-key me-2"></i>Security</h5>
                            <label class="form-label small">Active Sessions</label>
                            <ul class="list-group mb-2">


                                @foreach ($devices as $device)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $device['browser'] }} - {{ $device['platform'] }}

                                        @if ($device['is_current'])
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Last used {{ $device['last_seen'] }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
{{--                            <button class="btn btn-warning w-100">--}}
{{--                                <i class="bi bi-box-arrow-right me-2"></i>Logout from All Devices--}}
{{--                            </button>--}}
                        </div>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 shadow-sm border-danger">
                        <div class="card-body">
                            <h5 class="card-title text-danger"><i class="bi bi-trash me-2"></i>Danger
                                Zone</h5>
                            <a href="{{ route('delete-account') }}" class="btn btn-outline-danger w-100" id="deleteAccountBtn">
                                <i class="bi bi-x-circle me-2"></i>Delete Account
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection


@push('js')

    <script>
        $(document).ready(function() {
            $('#deleteAccountBtn').on('click', function(e) {
                e.preventDefault(); // stop normal link

                var url = $(this).attr('href');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will permanently delete your account!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url; // redirect to delete route
                    }
                });
            });
        });
    </script>
@endpush



