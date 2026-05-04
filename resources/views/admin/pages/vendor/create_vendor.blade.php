@extends('admin.layout.app')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush




@section('content')
    <!-- jQuery (ONLY ONE) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css">

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <style>
        /* Match normal input height */
        .select2-container .select2-selection--single {
            height: 42px !important;
            display: flex !important;
            align-items: center !important;
            border: 1px solid #d1d5db;
            /* gray-300 */
            border-radius: 6px;
        }

        /* Text vertical alignment */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 42px !important;
            padding-left: 12px;
            color: #374151;
            /* gray-700 */
        }

        /* Arrow alignment */
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 42px !important;
        }

        /* Full width */
        .select2-container {
            width: 100% !important;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h3 class="mb-4 text-center page-title">Create Vendor</h3>
                </div>
            </div>
        </div>


        <!-- end page title -->
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form class="pt-3" method="POST" action="{{route('admin.vendor.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <input type="first_name" class="form-control form-control-lg"
                                                name="first_name" id="name" placeholder="First Name *"
                                                value="{{ old('first_name') }}" required>
                                            <div class="mt-1">
                                                @error('first_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <input type="last_name" class="form-control form-control-lg"
                                                name="last_name" id="last_name" placeholder="Last Name"
                                                value="{{ old('last_name') }}">
                                            <div class="mt-1">
                                                @error('last_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <input type="phone" class="form-control form-control-lg" name="phone"
                                                id="phone" placeholder="Phone *" value="{{ old('phone') }}" required>
                                            <div class="mt-1">
                                                @error('phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-lg" name="email"
                                                id="email" placeholder="Email *" value="{{ old('email') }}" required>
                                            <div class="mt-1">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-lg" name="company_name"
                                                id="company_name" placeholder="Shop Name *"
                                                value="{{ old('company_name') }}" required>
                                            <div class="mt-1">
                                                @error('company_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-12">
                                        <div class="form-group">
                                            <input type="eamil" class="form-control form-control-lg"
                                                name="company_address" id="company_address"
                                                placeholder="Shop / Vendor Address *"
                                                value="{{ old('company_address') }}" required>
                                            <div class="mt-1">
                                                @error('company_address')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <select name="country" id="country" class="form-control country" required>
                                                <option>Select Country*</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="mt-1">
                                                @error('country')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <select name="city" id="city" class="form-control city" required>
                                                <option>Select City*</option>
                                            </select>
                                            <div class="mt-1">
                                                @error('city')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-lg" name="post_code"
                                                id="post_code" placeholder="Post Code *" value="{{ old('post_code') }}"
                                                required>
                                            <div class="mt-1">
                                                @error('post_code')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-lg" name="password"
                                                id="password" placeholder="Password" required>
                                            <div class="mt-1">
                                                @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-lg"
                                                name="password_confirmation" id="password"
                                                placeholder="Confirm Password" required>
                                            <div class="mt-1">
                                                @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                        type="submit">Vendor Register
                                    </button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function($) {
            $(document).ready(function() {
                if ($.fn.select2) {
                    $('#testSelect').select2();
                } else {
                    alert('Select2 not loaded');
                }
            });
        })(jQuery);
    </script>
@endsection


@push('js')
    <script src="{{ asset('https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            let jReq;
            ClassicEditor.create(document.querySelector('#long_description'))
                .then(editor => {
                    jReq = editor;
                })
                .catch(error => {
                    console.error(error);
                });


            ClassicEditor.create(document.querySelector('#additional_info_text'))
                .then(editor => {
                    jReq = editor;
                })
                .catch(error => {
                    console.error(error);
                });


        });
    </script>
    <script>
        $('.country').change(function () {
            var country_id = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ route('vendor.get-city') }}',
                type: 'POST',
                data: {
                    'country_id': country_id
                },
                success: function (data) {
                    $('.city').html(data)
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#country').select2();
            $('#city').select2();
        });
    </script>
@endpush
