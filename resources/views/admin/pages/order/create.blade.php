@extends('admin.layout.app')

@push('css')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    <style>
        .card-box {
            background-color: #fff;
            padding: 1.5rem;
            -webkit-box-shadow: 0 1px 4px 0 rgb(0 0 0 / 10%);
            box-shadow: 0 1px 4px 0 rgb(0 0 0 / 10%);
            margin-bottom: 24px;
            border-radius: 0.25rem;
        }
        a {
            text-decoration: none;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 15px !important;
        }

        .select2-container .select2-selection--single {
            height: 40px;
        }
    </style>
@endpush

@section('content')

    <div class="px-4 pt-4 container-fluid">

        <div class="pagetitle row">
            <div class="col-6">
                <h1><a href="{{ route('admin.dashboard') }}">Dashboard</a></h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Orders</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <strong>Customer Info</strong>
                    </div>
                    <div class="card-body">
{{--                        <div class="row">--}}


{{--                            <div class="col-lg-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="invoiceID">Invoice Number</label>--}}
{{--                                    <input type="text" readonly class="form-control" style="cursor: not-allowed;" id="invoiceID" value="{{ uniqid() }}">--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="customerName">Customer Name</label>
                                    <input type="text" class="form-control" id="customerName">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="customerPhone">Customer Phone</label>
                                    <input type="text" class="form-control" id="customerPhone">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="piva">P.I VA *</label>
                                    <input type="text" class="form-control" id="piva">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="codice_fiscal">Codice Fiscale *</label>
                                    <input type="text" class="form-control" id="codice_fiscal">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="cap">CAP *</label>
                                    <input type="text" class="form-control" id="cap">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="pec">PEC *</label>
                                    <input type="text" class="form-control" id="pec">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="catasto_destinatario">Catasto Detinatario *</label>
                                    <input type="text" class="form-control" id="catasto_destinatario">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="customerAddress">Customer Address</label>
                                    <textarea name="" class="form-control" placeholder="Customer Address" id="customerAddress" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="mb-1 col-lg-12">
                                <div class="form-group">
                                    <label for="customerNote">Customer Notes</label>
                                    <textarea name="" class="form-control" placeholder="Customer Notes" id="customerNote" rows="2"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="orderDate">Order Date</label>
                                    <input type="text" class="form-control datepicker" value="{{ date('Y-m-d') }}" id="orderDate">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <strong>Product Info</strong>
                    </div>
                    <div class="card-body">
                        <table id="productTable" style="width: 100% !important;" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Color</th>
                                <th>Variant</th>
                                <th>Code</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="7">
                                    <select id="productID" style="width: 100%;">
                                        <option value="">Select Product</option>
                                    </select>
                                </td>
                            </tr>
                            </tfoot>

                        </table>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputState" class="col-form-label">Choose Status</label>
                                    <select id="orderStatus" class="form-control">

                                        @forelse($orderStatus as $status)
                                            <option value="{{ $status->id }}">{{ $status->status_name }}</option>

                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="mb-2 form-group">
                                    <label>Payment</label>
                                    <input type="text" class="form-control" id="payment_type" placeholder="Enter Payment Type: COD, Bkash">
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-2 form-group row">
                                    <label for="fname" class="text-right col-sm-4 control-label col-form-label">Sub Total</label>
                                    <div class="col-sm-8">
                                        <span class="form-control" id="subtotal" style="cursor: not-allowed;"></span>
                                    </div>
                                </div>
                                <div class="mb-2 form-group row">
                                    <label for="fname" class="text-right col-sm-4 control-label col-form-label">Delivery</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="100" id="deliveryCharge">
                                    </div>
                                </div>
                                <div class="mb-2 form-group row">
                                    <label for="fname" class="text-right col-sm-4 control-label col-form-label">Discount</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="0" class="form-control" id="discountCharge">
                                    </div>
                                </div>

                                <div class="mb-2 form-group row paymentAmount">
                                    <label for="fname" class="text-right col-sm-4 control-label col-form-label">Payment</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="0" class="form-control" id="paymentAmount">
                                    </div>
                                </div>
                                <div class="mb-2 form-group row">
                                    <label for="fname" class="text-right col-sm-4 control-label col-form-label">Total</label>
                                    <div class="col-sm-8">
                                        <span class="form-control" id="total" style="cursor: not-allowed;"   >100</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" id="submit" class="btn btn-primary btn-block from-prevent-multiple-submits" data-style="expand-left">Save</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />


@endsection



@push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        (function(){
            $('.from-prevent-multiple-submits').on('submit', function(){
                $('.from-prevent-multiple-submits').attr('disabled','true');
                $('.spinner').css('display','inline');
            })
        })();

        $(document).ready(function() {

            //change order status
            var token = $("input[name='_token']").val();

            $(".paymentID").hide();
            $(".paymentAgentNumber").hide();
            $(".paymentAmount").hide();


            $(document).on("click", "#submit", function () {

                var invoiceID = $("#invoiceID");
                var web_id = $("#web_id");
                var customerName = $("#customerName");
                var orderStatus = $("#orderStatus");
                var customerPhone = $("#customerPhone");
                var piva = $("#piva");
                var codice_fiscal = $("#codice_fiscal");
                var cap = $("#cap");
                var pec = $("#pec");
                var catasto_destinatario = $("#catasto_destinatario");
                var customerAddress = $("#customerAddress");
                var courier_tracking_link = $("#courier_tracking_link");
                var customerNote = $("#customerNote");
                var storeID = $("#storeID");
                var total = +$("#total").text();
                var deliveryCharge = +$("#deliveryCharge").val();
                var discountCharge = +$("#discountCharge").val();
                var paymentTypeID = $("#paymentTypeID").val();
                var paymentID = $("#paymentID").val();
                var paymentAmount = +$("#paymentAmount").val();
                var paymentAgentNumber = $("#paymentAgentNumber").val();
                var orderDate = $("#orderDate");
                var courierID = $("#courierID");
                var cityID = +$("#cityID").val();
                var zoneID = +$("#zoneID").val();
                var payment_type = $("#payment_type").val();
                var product = [];
                var productCount = 0;

                $("#productTable tbody tr").each(function(index, value) {
                    var currentRow = $(this);
                    var obj = {};
                    obj.productColor = currentRow.find("#ProductColor").val();
                    obj.sigment = currentRow.find("#sigment").val();
                    obj.productSize = currentRow.find("#ProductSize").val();
                    obj.sizeID = currentRow.find(".sizeID").val();
                    obj.productID = currentRow.find(".productID").val();
                    obj.productCode = currentRow.find(".productCode").text();
                    if(currentRow.find("#ProductSize").val()=='' && currentRow.find("#prd").val()=='old'){
                        toastr.error('please select any size');
                        return false;
                    }
                    obj.productName = currentRow.find(".productName").text();
                    obj.productQuantity = currentRow.find(".productQuantity").val();
                    obj.productPrice = currentRow.find(".productPrice").val();
                    product.push(obj);
                    productCount++;
                });

                if (storeID.val() == '') {
                    toastr.error('Store Should Not Be Empty');
                    storeID.closest('.form-group').find('.select2-selection').css('border',
                        '1px solid red');
                    return;
                }

                storeID.closest('.form-group').find('.select2-selection').css('border',
                    '1px solid #ced4da');

                invoiceID.css('border', '1px solid #ced4da');
                if (web_id.val() == '') {
                    toastr.error('Order From Should Not Be Empty');
                    web_id.css('border', '1px solid red');
                    return;
                }
                web_id.css('border', '1px solid #ced4da');

                if (customerName.val() == '') {
                    toastr.error('Customer Name Should Not Be Empty');
                    customerName.css('border', '1px solid red');
                    return;
                }
                customerName.css('border', '1px solid #ced4da');

                if (customerPhone.val() == '') {
                    toastr.error('Customer Phone Should Not Be Empty');
                    customerPhone.css('border', '1px solid red');
                    return;
                }
                customerPhone.css('border', '1px solid #ced4da');

                if (piva.val() == '') {
                    toastr.error('P.I VA Should Not Be Empty');
                    piva.css('border', '1px solid red');
                    return;
                }
                piva.css('border', '1px solid #ced4da');

                if (codice_fiscal.val() == '') {
                    toastr.error('Codice Fiscale Should Not Be Empty');
                    codice_fiscal.css('border', '1px solid red');
                    return;
                }
                codice_fiscal.css('border', '1px solid #ced4da');
                if (cap.val() == '') {
                    toastr.error('CAP Should Not Be Empty');
                    cap.css('border', '1px solid red');
                    return;
                }
                cap.css('border', '1px solid #ced4da');

                if (pec.val() == '') {
                    toastr.error('PEC Should Not Be Empty');
                    pec.css('border', '1px solid red');
                    return;
                }
                pec.css('border', '1px solid #ced4da');
                if (catasto_destinatario.val() == '') {
                    toastr.error('Catasto Detinatario Should Not Be Empty');
                    catasto_destinatario.css('border', '1px solid red');
                    return;
                }
                catasto_destinatario.css('border', '1px solid #ced4da');

                if (customerAddress.val() == '') {
                    toastr.error('Customer Address Should Not Be Empty');
                    customerAddress.css('border', '1px solid red');
                    return;
                }
                customerAddress.css('border', '1px solid #ced4da');

                if (orderDate.val() == '') {
                    toastr.error('Order Date Should Not Be Empty');
                    orderDate.css('border', '1px solid red');
                    return;
                }
                orderDate.css('border', '1px solid #ced4da');

                if ($('#productTable tbody tr').length == 0) {

                    toastr.error('Product Should Not Be Empty');
                    return;
                }




                var data = {};
                data["invoiceID"] = invoiceID.val();
                data["web_id"] = web_id.val();
                data["storeID"] = storeID.val();
                data["customerName"] = customerName.val();
                data["status"] = orderStatus.val();
                data["customerPhone"] = customerPhone.val();
                data["piva"] = piva.val();
                data["codice_fiscal"] = codice_fiscal.val();
                data["cap"] = cap.val();
                data["pec"] = pec.val();
                data["catasto_destinatario"] = catasto_destinatario.val();
                data["customerAddress"] = customerAddress.val();
                data["customerNote"] = customerNote.val();
                data["courier_tracking_link"] = courier_tracking_link.val();
                data["total"] = total;
                data["deliveryCharge"] = deliveryCharge;
                data["discountCharge"] = discountCharge;
                data["paymentTypeID"] = paymentTypeID;
                data["paymentID"] = paymentID;
                data["paymentAmount"] = paymentAmount;
                data["paymentAgentNumber"] = paymentAgentNumber;
                data["orderDate"] = orderDate.val();
                data["courierID"] = +courierID.val();
                data["cityID"] = cityID;
                data["zoneID"] = zoneID;
                data["payment_type"] = payment_type;
                data["userID"] = $('#user_id').val();
                data["products"] = product;
                $.ajax({
                    type: "POST",
                    url: '{{ route('admin.order.store') }}',
                    data: {
                        'data': data,
                        '_token': token
                    },
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data["status"] === "success") {
                            toastr.success(data["message"]);
                            window.location.href = "{{ route('admin.order.index') }}";

                        } else {
                            toastr.error(data["message"])
                        }
                    }
                });



            });


            $("#productID").select2({
                placeholder: "Select a Product",
                dropdownParent: $('#productTable'),
                allowClear: true,
                templateResult: function (state) {
                    if (!state.id) {
                        return state.text;
                    }
                    var $state = $(
                        '<span><img width="60px" src="'+state.image +'" class="img-flag" /> '+state.text+'" (Color: "'+state.color+'",   Variant: "'+state.size+")</span>"
                    );
                    return $state;
                },
                ajax: {
                    type:'GET',
                    url: '{{ route('admin.products-for-sale')}}',
                    processResults: function (data) {
                        // 🔹 Only show products that are available
                        const filtered = data.data.filter(item => item.status === 'Available');

                        return {
                            results: filtered
                        };
                    }
                }
            }).trigger("change").on("select2:select", function (e) {
                $("#productTable tbody").append(
                    "<tr>" +
                    '<td style="display: none">' +
                    '<input type="hidden" id="prd" value="new">' +
                    '<input type="hidden" class="sizeID" value="' + e.params.data.size_id + '">' +
                    '<input type="text" class="productID" style="width:80px;" value="' + e.params.data.id + '">' +
                    '</td>' +
                    '<td><input type="text" name="color" id="ProductColor" value="' + e.params.data.color + '" readonly style="    max-width: 60px;"><br><img src="' + e.params.data.image + '" style="width:60px;margin-top:6px;"> </td>' +
                    '<td><input type="text" name="size" id="ProductSize" value="' + e.params.data.size + '" readonly style="    max-width: 40px;"></td>' +
                    '<td><span class="productCode">' + e.params.data.productCode + '</span></td>' +
                    '<td><span class="productName">' + e.params.data.text + '</span><br></td>' +
                    '<td><input type="number" class="productQuantity form-control" style="width:80px;" value="1"></td>' +
                    '<td><input type="text" name="productPrice" readonly class="productPrice" value="' + e.params.data.productPrice + '" style="max-width: 60px;"></td>' +
                    '<td><button class="btn btn-sm btn-danger delete-btn"><i class="fa fa-trash"></i></button></td>\n' +
                    "</tr>"
                );
                calculation();
                $('#productID').val(null).trigger('change');
            });


            $(document).on("change", ".productQuantity", function() {
                calculation();
            });
            $(document).on("input", ".productPrice", function() {
                calculation();
            });
            $(document).on("input", "#paymentAmount", function() {
                calculation();
            });
            $(document).on("input", "#deliveryCharge", function() {
                calculation();
            });
            $(document).on("input", "#discountCharge", function() {
                calculation();
            });
            calculation();

            function calculation() {
                var subtotal = 0;
                var deliveryCharge = +$("#deliveryCharge").val();
                var discountCharge = +$("#discountCharge").val();
                var paymentAmount = +$("#paymentAmount").val();
                $("#productTable tbody tr").each(function(index) {
                    subtotal = subtotal + +$(this).find(".productPrice")
                        .val() * +$(this).find(".productQuantity").val();
                });
                $("#subtotal").text(subtotal);
                $("#total").text(subtotal + deliveryCharge - paymentAmount -
                    discountCharge);
            }

            $(document).on("click", ".delete-btn", function() {
                $(this).closest("tr").remove();
                calculation();
            });

            // $(".datepicker").flatpickr();

        });

    </script>

@endpush
