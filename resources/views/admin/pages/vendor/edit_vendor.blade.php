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
                    <h3 class="mb-4 text-center page-title">Commission</h3>
                </div>
            </div>
        </div>


        <!-- end page title -->
        <div class="row justify-content-center">
            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="pt-3" method="POST" action="{{route('admin.approved.vendor.update', $vendor->id)}}">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="my-2 form-group">
                                        <label for="form-label">Email</label>
                                        <input type="email" class="form-control form-control-lg" name="email" id="name"
                                            value="{{ $vendor->email }}" readonly>
                                        <div class="mt-1">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="my-2 form-group">
                                        <label for="form-label">commission (%)</label>
                                        <input type="number" class="form-control form-control-lg" name="commission_value"
                                            id="commission_value" value="{{ $vendor->commission_value }}">
                                        <div class="mt-1">
                                            @error('commission_value')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                    type="submit">Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function ($) {
            $(document).ready(function () {
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
        $(document).ready(function () {

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
