@extends('admin.layout.app')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
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

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 15px !important;
        }

        .select2-container .select2-selection--single {
            height: 40px;
        }


        .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
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
                                            <h4 class="card-title text-center mt-4">Edit <span class="fw-bolder text-primary">{{ $productVariant->product->name }}</span> for Color <span class="fw-bolder text-primary">({{ $productVariant->productcolor->color_name }})</span> Variant <span class="fw-bolder text-primary">({{ $productVariant->variant_name }})</span></h4>
                                        </div>


                    <div class="card-body p-4">
                        <form name="form" id="AddProducts" enctype="multipart/form-data">
                            @csrf
                            <div class="row border border-light">
                                <div class="card-body">
                                    <div class="col-lg-12 mb-4">
                                        <div class="card">
                                            <div class="card-header p-0" id="headingOne">
                                                <h5 class="mb-0">
                                                    <button type="button" id="collupshead" class="btn btn-link"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseVariant"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                        <span class="text-uppercase m-0">Color</span>
                                                        <span class="text-uppercase m-0">+</span>
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
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td colspan="5">
                                                                <select id="mediavariantID" style="width: 100%;">
                                                                    <option value="">Select Product Color</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        </tfoot>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-4">
                                        <div class="card-header p-0" id="headingOne">
                                            <h5 class="mb-0">
                                                <button type="button" id="collupshead" class="btn btn-link">
                                                    <span class="text-uppercase m-0">Slider Images</span>
                                                </button>
                                            </h5>
                                        </div>
                                        <div class="mt-4">
                                            <input type="file" class="form-control" id="images" name="images[]" required
                                                   multiple>
                                        </div>

                                        <div id="image-preview" class="mt-2"
                                             style="display: flex; flex-wrap: wrap; gap: 10px;"></div>
                                    </div>
                                    <div class="col-lg-12 mb-4">
                                        <div class="card">
                                            <div class="card-header p-0" id="headingOne">
                                                <h5 class="mb-0">
                                                    <button type="button" id="collupshead" class="btn btn-link"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseSize"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                        <span class="text-uppercase m-0">Variant</span>
                                                        <span class="text-uppercase m-0">+</span>
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
                                                            <th>Trash</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td colspan="6">
                                                                <select id="sizevariantID" style="width: 100%;">
                                                                    <option value="">Select Product Variant</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        </tfoot>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" id="submit" class="btn btn-primary w-100 text-center">Add
                                        Variant
                                    </button>
                                </div>

                            </div>
{{--                            <input type="hidden" name="product_id" id="productID" value="{{ $id }}">--}}
                        </form>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('js')
    <script
        src="{{asset('https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{--    <script src="https://code.jquery.com/jquery-3.7.1.min.js"--}}
    {{--            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            adminTable.ajax.reload();
        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var token = $("input[name='_token']").val();

        $(document).on("click", "#submit", function () {


            var color = [];
            var colorCount = 0;
            $("#mediaTable tbody tr").each(function (index, value) {
                var currentRow = $(this);
                var obj = {};
                obj.mediaID = currentRow.find("#mediaID").val();
                obj.color = currentRow.find("#color").val();
                obj.image = currentRow.find("#image")[0].files[0];
                color.push(obj);
                colorCount++;
            });

            var variant = [];
            var variantCount = 0;
            $("#sizeTable tbody tr").each(function (index, value) {
                var currentRow = $(this);
                var obj = {};
                obj.sizeID = currentRow.find("#sizeID").val();
                obj.size = currentRow.find("#size").val();
                obj.RegularPrice = currentRow.find("#RegularPrice").val();
                obj.Discount = currentRow.find("#Discount").val();
                variant.push(obj);
                variantCount++;
            });


            if (variantCount == 0) {
                toastr.error('Product Variant Should Not Be Empty');
                return;
            }

            if (colorCount == 0) {
                toastr.error('Product Color Should Not Be Empty');
                return;
            }
            var inpu = document.getElementById('images');
            var filesCount = inpu.files.length;
            if (filesCount == 0) {
                toastr.error('Please Select Atleast One Slider Image');
                return;

            }

            let productID = $('#productID').val();

            var formData = new FormData();

            formData.append('product_id', productID);

            var fileList = $('#images').get(0).files;

            if (fileList.length > 0) {
                for (let i = 0; i < fileList.length; i += 1) {
                    formData.append('images[]', fileList[i]);
                }
            }

            variant.forEach((item, index) => {
                Object.entries(item).forEach(([key, value]) => {
                    formData.append(`variant[${index}][${key}]`, value);
                });
            });

            color.forEach((item, index) => {
                Object.entries(item).forEach(([key, value]) => {
                    formData.append(`color[${index}][${key}]`, value);
                });
            });


            $.ajax({
                type: "POST",
                url: '{{route('admin.product-variant.store')}}',
                data: formData,
                contentType: false,
                processData: false,

                success: function (response) {
                    var data = JSON.parse(response);
                    if (data["status"] === "success") {
                        toastr.success(data["message"]);
                        document.getElementById('AddProducts').reset();
                        adminTable.ajax.reload();

                    } else {
                        toastr.error(data["message"])
                    }
                }
            });


        });


        $("#mediavariantID").select2({
            placeholder: "Select a Product Color",
            templateResult: function (state) {
                if (!state.id) {
                    return state.text;
                }
                return $('<span>' + state.text + "</span>");
            },
            ajax: {
                type: 'GET',
                url: '{{ route('admin.product.color') }}',
                processResults: function (data) {
                    return {
                        results: data.data
                    };
                }
            }
        }).on("select2:select", function (e) {
            // Prevent duplicate color rows
            if ($("#mediaTable tbody tr").length >= 1) {
                alert("Only one color is allowed.");
                $(this).val(null).trigger("change");
                return;
            }

            $("#mediaTable tbody").append(
                "<tr>" +
                '<td><input type="text" id="mediaID" style="width:80px;border: none;color: black;" value="' + e.params.data.id + '" disabled></td>' +
                '<td><input type="text" name="color" id="color" style="width:80px;border: none;color: black;" value="' + e.params.data.text + '" disabled></td>' +
                '<td><img src="" style="width:50px"></td>' +
                '<td><input type="file" id="image" class="form-control"></td>' +
                '<td><button type="button" class="btn btn-sm btn-danger delete-btn"><i class="fa fa-trash"></i></button></td>' +
                "</tr>"
            );

            // Disable further selection
            $(this).prop("disabled", true);
        });

        // Enable back when deleting
        $(document).on("click", ".delete-btn", function () {
            $(this).closest("tr").remove();
            $("#mediavariantID").prop("disabled", false).val(null).trigger("change");


        });

        $("#sizevariantID").select2({
            placeholder: "Select a Product Variant",
            templateResult: function (state) {
                if (!state.id) {
                    return state.text;
                }
                var $state = $(
                    '<span>' +
                    state.text +
                    "</span>"
                );
                return $state;
            },
            ajax: {
                type: 'GET',
                url: '{{route('admin.product.variant')}}',
                processResults: function (data) {

                    // var data = $.parseJSON(data);
                    console.log(data);
                    return {
                        results: data.data
                    };
                }
            }
        }).trigger("change").on("select2:select", function (e) {
            $("#sizeTable tbody").append(
                "<tr>" +
                '<td><input type="text" id="sizeID" style="width:80px;border: none;color: black;" value="' + e.params.data.id + '" disabled></td>' +
                '<td><input type="text" name="size" id="size" style="width:50px;border: none;color: black;" value="' + e.params.data.text + '" disabled> </td>' +
                '<td><input type="text" name="RegularPrice" id="RegularPrice" class="form-control" style="width:80px;float:left;">  <span id="taka">TK</span></td>' +
                '<td><input type="text" name="Discount" id="Discount" class="form-control" style="width:80px;float:left;"> <span id="taka">TK</span></td>' +
                '<td><span id="total">Total: 0 pics<br>Avalable: 0 pics<br>Sold: 0 pics<br></span></td>' +
                '<td><button type="button" class="btn btn-sm btn-danger delete-btn"><i class="fa fa-trash"></i></button></td>\n' +
                "</tr>"
            );
        });


        $(document).on("click", ".delete-btn", function () {
            $(this).closest("tr").remove();
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
