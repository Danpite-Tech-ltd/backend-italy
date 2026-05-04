@extends('admin.layout.app')

@push('css')
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


    {{-- <select id="testSelect" style="width:300px">
    <option value="">Select item</option>
    <option value="1">Item One</option>
    <option value="2">Item Two</option>
</select> --}}






    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h3 class="page-title mb-4 text-center">Product Basic Information</h3>
                </div>
            </div>
        </div>


        <!-- end page title -->
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" class="row" action="{{ route('admin.product.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Product Name *</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                        id="name">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- col-end -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="category_id" class="form-label">Categories *</label>
                                    <select class="form-control select2" name="category_id" id="category_id">
                                        <option value="">Select..</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="subcategory_id" class="form-label">SubCategories (Optional)</label>
                                    <select class="form-control select2" id="subcategory_id" name="subcategory_id"
                                        data-placeholder="Choose ...">
                                        <option value="">Select Subcategory</option>
                                    </select>
                                    @error('subcategory_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="vendor_id" class="form-label">Vendors</label>
                                    <select id="testSelect" class="form-control " value="{{ old('vendor_id') }}"
                                        name="vendor_id">
                                        <option value="" disabled selected>Select Vendors..</option>
                                        @foreach ($vendors as $value)
                                            <option value="{{ $value->id }}">{{ $value->company_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('vendor_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <select id="testSelect" style="width:300px">
                                <option value="">Select item</option>
                                <option value="1">Item One</option>
                                <option value="2">Item Two</option>
                            </select> --}}

                            <!-- col end -->
                            {{-- <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="childcategory_id" class="form-label">Child Categories
                                        (Optional)</label>
                                    <select class="form-control select2" id="childcategory_id" name="childcategory_id" data-placeholder="Choose ...">
                                        <option value=""> Select Child Category</option>
                                    </select>
                                    @error('childcategory_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                            </div> --}}
                            <!-- col end -->

                            {{-- <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="category_id" class="form-label">Brands</label>
                                    <select id="brand_id"
                                            class="form-control select2"
                                            value="{{ old('brand_id') }}" name="brand_id">
                                        <option value="">Select..</option>
                                        @foreach ($brands as $value)
                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div> --}}


                            <!-- col-end -->

                            <div class="col-sm-6 mb-3">
                                <label for="thumbnail_img">Thumbnail Image (218 X 218) *</label>

                                <div class="input-group control-group increment">
                                    <input type="file" name="thumbnail_img" id="thumbnail_img" class="form-control" />

                                    @error('thumbnail_img')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="youtube_link" class="form-label">Youtube Video (Optional)</label>
                                    <input type="text" class="form-control" name="youtube_link"
                                        value="{{ old('youtube_link') }}" id="youtube_link" />
                                    @error('youtube_link')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4 col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="product_type_id" class="form-label">Product Type</label>
                                    <select class="form-control" id="product_type_id" name="product_type_id">
                                        @forelse($productTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="product_type_id" class="form-label">Affiliate Commission </label>
                                    <input type="number" class="form-control" name="affiliate_commission"
                                        value="{{ old('affiliate_commission', 0) }}">
                                    @error('affiliate_commission')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="short_description">Short Description</label>
                                    <textarea name="short_description" id="short_description" rows="3" class="form-control"></textarea>
                                    @error('short_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="shipping_return_text">Shipping & Returns</label>
                                    <textarea name="shipping_return_text" id="shipping_return_text" rows="3" class="form-control"></textarea>
                                    @error('shipping_return_text')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="long_description">Long Description</label>
                                    <textarea name="long_description" id="long_description" rows="3" class="form-control"></textarea>
                                    @error('long_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="additional_info_text">Additional Information</label>
                                    <textarea name="additional_info_text" id="additional_info_text" rows="3" class="form-control"></textarea>
                                    @error('additional_info_text')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <input type="text" class="form-control" name="meta_title"
                                        value="{{ old('meta_title') }}" id="meta_title" />
                                    @error('SKU')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <input type="text" class="form-control" name="meta_description"
                                        value="{{ old('meta_description') }}" id="meta_description" />
                                    @error('meta_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="meta_image" class="form-label">Meta Image</label>
                                    <input type="file" class="form-control" name="meta_image" id="meta_image" />
                                    @error('meta_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="google_schema" class="form-label">Google Schema</label>
                                    <input type="text" class="form-control" name="google_schema"
                                        id="google_schema" />
                                    @error('google_schema')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12 justify-content-center d-flex mt-4 w-100">
                                <button type="submit" class="btn btn-primary me-2 w-100">Continue</button>
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

        //   Subcategories by  Category
        $(document).on('change', '#category_id', function() {
            let categoryId = $(this).val();

            if (categoryId) {
                $.ajax({
                    url: "{{ route('admin.subcategory-by-category', ':id') }}".replace(':id', categoryId),
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        let subcategorySelect = $('#subcategory_id');
                        subcategorySelect.empty().append(
                            '<option value="">Select Subcategory</option>');

                        if (response.status === 'success' && response.data.length > 0) {
                            $.each(response.data, function(index, subcategory) {
                                subcategorySelect.append('<option value="' + subcategory.id +
                                    '">' + subcategory.name + '</option>');
                            });
                        }
                    },
                    error: function() {
                        alert('Error fetching subcategories.');
                    }
                });
            } else {
                $('#subcategory_id').empty().append('<option value="">Select Subcategory</option>');
            }
        });

        // Child Categories by Subcategory
        $(document).on('change', '#subcategory_id', function() {
            let categoryId = $(this).val();

            if (categoryId) {
                $.ajax({
                    url: "{{ route('admin.child-category-by-subcategory', ':id') }}".replace(':id',
                        categoryId),
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        let subcategorySelect = $('#childcategory_id');
                        subcategorySelect.empty().append(
                            '<option value="">Select Subcategory</option>');

                        if (response.status === 'success' && response.data.length > 0) {
                            $.each(response.data, function(index, subcategory) {
                                subcategorySelect.append('<option value="' + subcategory.id +
                                    '">' + subcategory.name + '</option>');
                            });
                        }
                    },
                    error: function() {
                        alert('Error fetching subcategories.');
                    }
                });
            } else {
                $('#subcategory_id').empty().append('<option value="">Select Subcategory</option>');
            }
        });
    </script>
@endpush
