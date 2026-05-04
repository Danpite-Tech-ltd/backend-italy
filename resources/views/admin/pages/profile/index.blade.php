@extends('admin.layout.app')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">
@endpush


@section('content')
    {{--    Form Starts --}}
    <form method="post" action="{{ route('admin.profile.update', $user->id) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center mt-2">Profile Information</h4>

                    </div>
                    <div class="card-body p-4">

                        <div class="row">
                            <div class="col-lg-6">
                                <div>
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

                                    <!--fav icon-->

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input class="form-control" type="text" name="name" placeholder=""
                                            id="name" value="{{ $user->name ?? '' }}">
                                        <div class="mt-2">
                                            @error('name')
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
                                        <label for="address" class="form-label">Address</label>
                                        <textarea id="address" name="address" class="form-control">{{ $user->address ?? '' }}
                                                    </textarea>

                                        <div class="mt-2">
                                            @error('address')
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
                </div>
            </div> <!-- end col -->
        </div>

        <div class="text-center mt-2 mb-2 d-grid">
            <button class="btn btn-primary">Update</button>
        </div>
    </form>
@endsection



@push('js')
@endpush
