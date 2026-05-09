@extends('admin.layout.app')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">
    <style>
        div#roleinfo_length {
            color: red;
        }

        div#roleinfo_filter {
            color: red;
        }

        div#roleinfo_info {
            color: red;
        }

        #collupshead {
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        #taka {
            font-size: 25px;
            padding-left: 14px;
            color: black;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            color: #fff;
            background-color: #1b1b29 !important;
        }
    </style>
@endpush


@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h4 class="mt-4 text-center card-title">Edit <span
                                class="fw-bolder text-primary">{{ $productVariant->product->name }}</span> for Color <span
                                class="fw-bolder text-primary">({{ $productVariant->productcolor->color_name }})</span>
                            Variant <span class="fw-bolder text-primary">({{ $productVariant->variant_name }})</span></h4>
                    </div>


                    <div class="p-4 card-body">
                        <form name="form" id="AddProducts" enctype="multipart/form-data">
                            @csrf
                            <div class="border row border-light">
                                <div class="card-body">
                                    <div class="mb-4 col-lg-12">
                                        <div class="card">
                                            <div class="p-0 card-header" id="headingOne">
                                                <h5 class="mb-0">
                                                    <button type="button" id="collupshead" class="btn btn-link"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseVariant"
                                                        aria-expanded="true" aria-controls="collapseOne">
                                                        <span class="m-0 text-uppercase">Color</span>
                                                        <span class="m-0 text-uppercase">+</span>
                                                    </button>
                                                </h5>
                                            </div>

                                            <div id="collapseVariant" class="collapse show" aria-labelledby="headingOne"
                                                data-parent="#accordion">
                                                <div class="card-body">
                                                    <table id="mediaTable" style="width: 100% !important;"
                                                        class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Color</th>
                                                                <th>Image</th>
                                                                <th>Choose File</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" id="mediaID"
                                                                        style="width:80px;border: none;color: black;"
                                                                        value="{{ $productVariant->productcolor->id }}"
                                                                        readonly>
                                                                </td>
                                                                <td>
                                                                    <select name="productcolor_id" id="productcolorID" class="form-control">
                                                                        @foreach($colors as $color)
                                                                            @php
                                                                                $normalizedImage = '';
                                                                                if (!empty($color->image)) {
                                                                                    $normalizedImage = str_replace(['public/', 'public\\'], '', $color->image);
                                                                                }
                                                                                $sliderImages = collect(json_decode($color->images ?? '[]', true) ?: [])->map(function ($img) {
                                                                                    return asset(str_replace(['public/', 'public\\'], '', $img));
                                                                                })->all();
                                                                            @endphp
                                                                            <option value="{{ $color->id }}"
                                                                                data-image="{{ $normalizedImage ? asset($normalizedImage) : '' }}"
                                                                                data-images='@json($sliderImages)'
                                                                                {{ $color->id == $productVariant->productcolor->color_id ? 'selected' : '' }}>
                                                                                {{ $color->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <img id="currentColorImage"
                                                                        src="{{ asset($productVariant->productcolor->image) }}"
                                                                        style="width:50px">
                                                                </td>
                                                                <td><input type="file" id="image" class="form-control"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-lg-12">
                                        <div class="p-0 card-header" id="headingOne">
                                            <h5 class="mb-0">
                                                <button type="button" id="collupshead" class="btn btn-link">
                                                    <span class="m-0 text-uppercase">Slider Images</span>
                                                </button>
                                            </h5>
                                        </div>
                                        <div class="mt-4">
                                            <input type="file" class="form-control" id="images" name="images[]" multiple>
                                        </div>
                                        <div class="mt-3">
                                            <label class="form-label">Current Slider Images</label>
                                            <div id="current-image-preview" class="mt-2"
                                                style="display:flex; flex-wrap:wrap; gap:10px;">
                                                @if($productVariant->productcolor && $productVariant->productcolor->images)
                                                    @foreach(json_decode($productVariant->productcolor->images, true) as $slideImg)
                                                        <div style="width:80px; position:relative;">
                                                            <img src="{{ asset($slideImg) }}"
                                                                style="width:100%; height:80px; object-fit:cover; border:1px solid #ddd; border-radius:5px;">
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div id="image-preview" class="mt-2"
                                            style="display: flex; flex-wrap: wrap; gap: 10px;"></div>
                                    </div>
                                    <div class="mb-4 col-lg-12">
                                        <div class="card">
                                            <div class="p-0 card-header" id="headingOne">
                                                <h5 class="mb-0">
                                                    <button type="button" id="collupshead" class="btn btn-link"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseSize"
                                                        aria-expanded="true" aria-controls="collapseOne">
                                                        <span class="m-0 text-uppercase">Variant</span>
                                                        <span class="m-0 text-uppercase">+</span>
                                                    </button>
                                                </h5>
                                            </div>

                                            <div id="collapseSize" class="collapse show" aria-labelledby="headingOne"
                                                data-parent="#accordion">
                                                <div class="card-body">
                                                    <table id="sizeTable" style="width: 100% !important;"
                                                        class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Size</th>
                                                                <th>Regular Price</th>
                                                                <th>Sale Price</th>
                                                                <th>Stock</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" id="sizeID"
                                                                        style="width:80px;border: none;color: black;"
                                                                        value="{{ $productVariant->variant_id }}" readonly>
                                                                </td>
                                                                <td>
                                                                    <select name="variant_id" id="variantID" class="form-control">
                                                                        @foreach($productVariants as $variantOption)
                                                                            <option value="{{ $variantOption->id }}"
                                                                                @if($variantOption->id == $productVariant->variant_id) selected="selected" @endif>
                                                                                {{ $variantOption->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td><input type="text" name="RegularPrice" id="RegularPrice"
                                                                        class="form-control" style="width:120px;float:left;"
                                                                        value="{{ $productVariant->regular_price }}"></td>
                                                                <td><input type="text" name="Discount" id="Discount"
                                                                        class="form-control" style="width:120px;float:left;"
                                                                        value="{{ $productVariant->sale_price }}"></td>
                                                                <td><span id="total">Total:
                                                                        {{ $productVariant->total_stock }}
                                                                        pics<br>Available:
                                                                        {{ $productVariant->available_stock }} pics<br>Sold:
                                                                        {{ $productVariant->sold_stock }} pics<br></span>
                                                                </td>
                                                            </tr>
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" id="submit" class="text-center btn btn-primary w-100">Edit
                                        Variant
                                    </button>
                                </div>

                            </div>
                            <input type="hidden" name="product_id" id="productID" value="{{ $productVariant->product_id }}">
                            <input type="hidden" name="product_variant_id" id="productVariantID"
                                value="{{ $productVariant->id }}">
                        </form>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('js')
    <script src="{{asset('https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js')}}"></script>

    {{--
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" --}} {{--
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var token = $("input[name='_token']").val();

        $(document).on("click", "#submit", function () {
            var mediaRow = $("#mediaTable tbody tr");
            var sizeRow = $("#sizeTable tbody tr");

            if (mediaRow.length === 0) {
                toastr.error('Product Color Should Not Be Empty');
                return;
            }
            if (sizeRow.length === 0) {
                toastr.error('Product Variant Should Not Be Empty');
                return;
            }

            var formData = new FormData();
            formData.append('product_id', $('#productID').val());
            formData.append('productcolor_id', $('#productcolorID').val());
            var variantId = $('#variantID').val() || '{{ $productVariant->variant_id }}';
            formData.append('variant_id', variantId);
            formData.append('RegularPrice', sizeRow.find('#RegularPrice').val());
            formData.append('Discount', sizeRow.find('#Discount').val());

            var variantImage = mediaRow.find('#image')[0].files[0];
            if (variantImage) {
                formData.append('image', variantImage);
            }

            var fileList = $('#images').get(0).files;
            if (fileList.length > 0) {
                for (let i = 0; i < fileList.length; i += 1) {
                    formData.append('images[]', fileList[i]);
                }
            }

            $.ajax({
                type: "POST",
                url: '{{ route('admin.product-variant.update', $productVariant->id) }}',
                data: formData,
                contentType: false,
                processData: false,

                success: function (response) {
                    var data = typeof response === 'string' ? JSON.parse(response) : response;
                    if (data["status"] === "success") {
                        toastr.success(data["message"]);
                    } else {
                        toastr.error(data["message"]);
                    }
                }
            }).fail(function (xhr) {
                var message = 'Update failed';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    try {
                        var json = JSON.parse(xhr.responseText);
                        message = json.message || message;
                    } catch (e) {}
                }
                toastr.error(message);
            });


        });

        function renderCurrentSliderImages(images) {
            var preview = $('#current-image-preview');
            preview.empty();

            if (!images || images.length === 0) {
                preview.append('<div style="width:80px; min-height:80px; display:flex; align-items:center; justify-content:center; border:1px solid #ddd; color:#666;">No images</div>');
                return;
            }

            images.forEach(function (img) {
                preview.append('<div style="width:80px; position:relative;"><img src="' + img + '" style="width:100%; height:80px; object-fit:cover; border:1px solid #ddd; border-radius:5px;"></div>');
            });
        }

        // Removed color change image update

        $(document).on('change', '#productcolorID', function () {
            var selectedImage = $(this).find('option:selected').data('image');
            if (selectedImage) {
                $('#currentColorImage').attr('src', selectedImage);
            }
        });

    </script>

    <script>
        let selectedFiles = [];

        document.getElementById("images").addEventListener("change", function (event) {
            let preview = document.getElementById("image-preview");
            preview.innerHTML = "";
            selectedFiles = Array.from(event.target.files); // store files

            selectedFiles.forEach((file, index) => {
                if (file.type.startsWith("image/")) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        let wrapper = document.createElement("div");
                        wrapper.style.position = "relative";
                        wrapper.style.display = "inline-block";

                        let img = document.createElement("img");
                        img.src = e.target.result;
                        img.style.width = "80px";
                        img.style.height = "80px";
                        img.style.objectFit = "cover";
                        img.style.border = "1px solid #ddd";
                        img.style.borderRadius = "5px";

                        let removeBtn = document.createElement("span");
                        removeBtn.innerHTML = "&times;";
                        removeBtn.style.position = "absolute";
                        removeBtn.style.top = "2px";
                        removeBtn.style.right = "5px";
                        removeBtn.style.cursor = "pointer";
                        removeBtn.style.background = "rgba(0,0,0,0.5)";
                        removeBtn.style.color = "white";
                        removeBtn.style.padding = "0 5px";
                        removeBtn.style.borderRadius = "50%";
                        removeBtn.style.fontSize = "14px";
                        removeBtn.title = "Remove image";

                        removeBtn.addEventListener("click", function () {
                            selectedFiles.splice(index, 1);
                            updateFileInput();
                            wrapper.remove();
                        });

                        wrapper.appendChild(img);
                        wrapper.appendChild(removeBtn);
                        preview.appendChild(wrapper);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

        function updateFileInput() {
            let dt = new DataTransfer();
            selectedFiles.forEach(file => dt.items.add(file));
            document.getElementById("images").files = dt.files;
        }
    </script>


@endpush
