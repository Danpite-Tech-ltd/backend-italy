@extends('vendor.layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">
@endpush


@section('content')
    {{--    Form Starts --}}
    <form method="post" action="{{ route('vendor.profile.update', $user->id) }}" enctype="multipart/form-data">

        @csrf
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mt-2 text-center card-title">Profile Information</h4>

                    </div>
                    <div class="p-4 card-body">

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div>

                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input class="form-control" type="text" name="first_name" placeholder=""
                                            id="first_name" value="{{ $user->first_name ?? '' }}">
                                        <div class="mt-2">
                                            @error('first_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input class="form-control" type="text" name="last_name" placeholder=""
                                            id="last_name" value="{{ $user->last_name ?? '' }}">
                                        <div class="mt-2">
                                            @error('last_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input class="form-control" type="email" name="email"
                                            placeholder="xyz@gmail.com" id="email" value="{{ $user->email ?? '' }}"
                                            readonly>

                                        <div class="mt-2">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input class="form-control" name="phone" type="text"
                                            placeholder="Enter Phone Number" id="phone"
                                            value="{{ $user->phone ?? '' }}">

                                        <div class="mt-2">
                                            @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="company_name" class="form-label">Shop Name</label>
                                        <input class="form-control" name="company_name" type="text"
                                            placeholder="Enter Shop Name" id="company_name"
                                            value="{{ $user->company_name ?? '' }}">

                                        <div class="mt-2">
                                            @error('company_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="address" class="form-label">Shop Address</label>
                                        <textarea id="address" name="address" class="form-control">{{ $user->company_address ?? '' }}
                                                    </textarea>

                                        <div class="mt-2">
                                            @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="mb-3">
                                    <label for="country" class="form-label">Country Name</label>
                                    <input class="form-control" name="country" type="text"
                                        placeholder="Enter Country Name" id="country" value="{{ $user->country ?? '' }}">

                                    <div class="mt-2">
                                        @error('country')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="city" class="form-label">City Name</label>
                                    <input class="form-control" name="city" type="text" placeholder="Enter City Name"
                                        id="city" value="{{ $user->city ?? '' }}">

                                    <div class="mt-2">
                                        @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="post_code" class="form-label">Post Code</label>
                                    <input class="form-control" name="post_code" type="text"
                                        placeholder="Enter Post Code" id="post_code"
                                        value="{{ $user->post_code ?? '' }}">

                                    <div class="mt-2">
                                        @error('post_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <input class="form-control" type="text" name="status" id="status"
                                        value="{{ $user->status ?? '' }}" readonly>

                                    <div class="mt-2">
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="profile_image" class="form-label">Profile Picture</label>
                                    <input oninput="bLogoImgPrev.src=window.URL.createObjectURL(this.files[0])"
                                        class="form-control" type="file" name="profile_image" id="profile_image" />
                                    @if ($user && $user->profile_image)
                                        <img id="bLogoImgPrev" class="mt-1" src="{{ asset($user->profile_image) }}"
                                            height="80" width="80" alt="" />
                                    @endif
                                    <div class="mt-2">
                                        @error('profile_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Change Password</label>
                                    <input class="form-control" name="change_password" type="password"
                                        placeholder="Enter Change Password">


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>

        <div class="mt-2 mb-2 text-center d-grid">
            <button class="btn btn-primary">Update</button>
        </div>
    </form>
@endsection



@push('js')
@endpush
