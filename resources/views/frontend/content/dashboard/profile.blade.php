@extends('frontend.content.dashboard.layout.app')

@section('css')


@endsection


@section('content')

    <div class="main-content">

        <!-- Main Content Area -->
        <div class="p-4">
            <div class="text-center section-content"><!-- ✅ Center everything -->
                <!-- Profile Header -->
                <div class="mb-4 profile-info-card">
                    <div class="mb-3 profile-image-container">
                        @if(isset(Auth::user()->profile_image))
                            <img src="{{ asset(Auth::user()->profile_image) }}" alt="Profile" class="profile-image" id="profileImage" height="100px" width="100px">
                        @else
                            <img src="{{ asset('public/admin') }}/images/faces/face29.png" alt="Profile" class="profile-image" id="profileImage" height="100px" width="100px">
                        @endif

                        <label for="imageUpload" class="image-upload-btn">
                            <i class="bi bi-camera"></i>
                        </label>
                        <input type="file" id="imageUpload" accept="image/*" style="display: none;">
                    </div>
                    <h3 class="mb-1" id="displayName">{{ Auth::user()->name ?? '' }}</h3>
{{--                    <p class="mb-0 text-muted" id="displayTitle">Digital Marketer</p>--}}
                </div>

                <!-- Profile Information -->
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="profile-info-card">
                            <h5 class="mb-3">Personal Information</h5>

                            <form id="profileForm" class="text-center" method="POST" action="{{ route('user-profile-update') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="mx-auto mb-3 col-md-6">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="text-center form-control" name="name" id="firstName" value="{{ Auth::user()->name ?? '' }}">
                                    </div>

                                    <div class="mx-auto mb-3 col-md-6">
                                        <label class="form-label">Image</label>
                                        <input type="file" class="text-center form-control" name="profile_image" id="ProfileImage">
                                    </div>

                                    <div class="mx-auto mb-3 col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="text-center form-control" id="email" name="email" value="{{ Auth::user()->email ?? '' }}">
                                    </div>

                                    <div class="mx-auto mb-3 col-md-6">
                                        <label class="form-label">Phone</label>
                                        <input type="tel" class="text-center form-control" name="phone" id="phone" value="{{ Auth::user()->phone ?? '' }}">
                                    </div>

                                    <div class="mb-3 col-12">
                                        <label class="form-label">Address</label>
                                        <textarea  class="text-center form-control" name="address" id="address">{{ Auth::user()->address ?? '' }}</textarea>
                                    </div>

{{--                                    <div class="mx-auto mb-3 col-md-6">--}}
{{--                                        <label class="form-label">Date of Birth</label>--}}
{{--                                        <input type="date" class="text-center form-control" id="dateOfBirth" value="1990-05-15">--}}
{{--                                    </div>--}}
{{--                                    --}}
{{--                                    <div class="mx-auto mb-3 col-md-6">--}}
{{--                                        <label class="form-label">Gender</label>--}}
{{--                                        <select class="text-center form-control" id="gender">--}}
{{--                                            <option value="male" selected="">Male</option>--}}
{{--                                            <option value="female">Female</option>--}}
{{--                                            <option value="other">Other</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                    <div class="mb-3 col-12">--}}
{{--                                        <label class="form-label">Bio</label>--}}
{{--                                        <textarea class="text-center form-control" id="bio" rows="3">Passionate developer with 5+ years of experience in full-stack development. Love creating innovative solutions and working with cutting-edge technologies.</textarea>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <div class="edit-actions">
                                    <button type="submit" class="btn btn-primary save-btn me-2">
                                        <i class="bi bi-check2 me-2"></i>Save Changes
                                    </button>
                                    <a href="{{ route('dashboard') }}" class="btn btn-secondary cancel-btn" id="cancelEditBtn">
                                        <i class="bi bi-x me-2"></i>Cancel
                                    </a>
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

