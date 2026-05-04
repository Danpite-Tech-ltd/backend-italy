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
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <strong>Customer Info</strong>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="invoiceID">Invoice Number</label>
                                <input type="text" readonly class="form-control" style="cursor: not-allowed;"
                                       id="invoiceID" value="{{ $order->invoiceID }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="customerName">Customer Name</label>
                                <input type="text" class="form-control" id="customerName"
                                       value="{{ $order->customer->name ?? '' }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="customerPhone">Customer Phone</label>
                                <input type="text" class="form-control" id="customerPhone"
                                       value="{{ $order->customer->phone ?? '' }}">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="piva">P.I VA *</label>
                                <input type="text" class="form-control" id="piva"
                                       value="{{ $order->customer->piva ?? '' }}" placeholder="Enter P.I VA">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="codice_fiscal">Codice Fiscal *</label>
                                <input type="text" class="form-control" id="codice_fiscal"
                                       value="{{ $order->customer->codice_fiscal ?? '' }}" placeholder="Enter Codice Fiscal">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="cap">CAP *</label>
                                <input type="text" class="form-control" id="cap"
                                       value="{{ $order->customer->cap ?? '' }}" placeholder="Enter CAP">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="pec">PEC *</label>
                                <input type="text" class="form-control" id="pec"
                                       value="{{ $order->customer->pec ?? '' }}" placeholder="Enter PEC">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="catasto_destinatario">Catasto Destinatario *</label>
                                <input type="text" class="form-control" id="catasto_destinatario"
                                       value="{{ $order->customer->catasto_destinatario ?? '' }}" placeholder="Enter Catasto Destinatario">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="customerAddress">Customer Address</label>
                                <textarea name="" class="form-control" placeholder="Customer Address"
                                          id="customerAddress" rows="2">{{ $order->customer->address ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 mb-1">
                            <div class="form-group mb-3" id="courierdatatbl">
                                <label for="courierID">Courier Name</label><br>
                                <select id="courierID" class="form-control">
                                    @forelse($couriers as $courier)
                                        <option value="{{ $courier->id }}"
                                                @if($courier->id == $order->courier_id) selected @endif>{{ strtoupper($courier->type) }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 mb-1">
                            @isset($order->consignmentID)
                                <div class="form-group">
                                    <label for="courierID">Consignment ID</label><br>
                                    <input type="text" class="form-control" id="consignmentID"
                                           value="{{ $order->consignmentID }}" readonly>
                                </div>
                            @endisset
                        </div>

                        {{--Pathao--}}
                        @if($order->consignmentID && $order->courier_id == 2)
                            <div class="col-lg-4 mb-1">
                                <div class="form-group">
                                    <label for="courierID">Track Order Here</label><br>
                                    <a href="https://merchant.pathao.com/courier/orders/{{ $order->consignmentID }}"
                                       class="btn  btn-info" target="_blank"><i class="fa fa-truck"></i> Track Order</a>
                                </div>
                            </div>

                        {{--Steadfast--}}
                        @elseif($order->consignmentID && $order->courier_id == 3)
                            <div class="col-lg-4 mb-1">
                                <label for="courierID">Track Order Here</label><br>
                                <a href="https://steadfast.com.bd/user/consignment/{{ $order->consignmentID }}" class="btn btn-info" target="_blank"><i class="fa fa-truck"></i> Track Order</a>
                            </div>
                        @endif


                        <div class="col-lg-12 mb-1">
                            <div class="form-group">
                                <label for="customerNote">Customer Notes</label>
                                <textarea name="" class="form-control" placeholder="Customer Notes" id="customerNote"
                                          rows="2">{{ $order->customer_note }}</textarea>
                            </div>
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="orderDate">Order Date</label>
                                <input type="text" class="form-control datepicker" value="{{ $order->order_date }}"
                                       id="orderDate">
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
                    <table id="productTable" style="width: 100% !important;"
                           class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Code</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($order->orderProducts as $product)
                            <tr>
                                <td style="display: none">
                                    <input type="hidden" id="prd" value="old">
                                    <input type="text" class="productID" style="width:80px;"
                                           value="{{ $product->product_id }}">
                                    <input type="hidden" class="sizeID" value="{{ $product->productvariant_id }}">
                                </td>
                                <td>
                                <span class="Color"> <input type="text" name="color" id="ProductColor"
                                                            value="{{ $product->color }}" style="max-width: 60px;">
                                    <br>
                                    <a target="_blank" href="">
                                        <img src="{{ asset($product->product->thumbnail_img) }}"
                                             style="width:60px;margin-top:6px;">
                                    </a>
                                </span>
                                </td>
                                <td>
                                    <input type="text" name="size" id="ProductSize" value=" {{ $product->variant }}"
                                           readonly style="    max-width: 40px;">
                                </td>
                                <td><span class="productCode">{{ $product->product_SKU }}</span></td>
                                <td>
                                    <span class="productName">{{ $product->product_name }}<br>

                                    </span>
                                </td>
                                <td><input type="number" class="productQuantity form-control" style="width:80px;"
                                           value="{{ $product->quantity }}"></td>
                                <td><input type="text" name="productPrice" class="productPrice"
                                           value="{{ $product->product_price }}" style="max-width: 60px;"></td>
                                <td>
                                    <button class="btn btn-sm btn-danger delete-btn"><i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="7">
                                <select id="productID" type="text" style="width: 100%;" class="form-control">
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
                                        <option value="{{ $status->id }}"
                                                @if($order->order_status_id == $status->id ) selected @endif> {{ $status->status_name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>

                            <div class="mb-2 form-group">
                                <label>Payment</label>
                                <input type="text" class="form-control" id="payment_type"
                                       value="{{ $order->payment_method ?? '' }}"
                                       placeholder="Enter Payment Type: COD, Bkash">
                            </div>

                            <div class="mb-2 form-group">
                                <label>Assign to</label>
                                <select id="user_id" class="form-control">
                                    <option value="">Select User</option>
                                    @forelse($admins as $admin)
                                        <option value="{{ $admin->id }}"
                                                @if($order->admin_id == $admin->id) selected @endif> {{ $admin->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group row mb-2">
                                <label for="fname" class="col-sm-4 text-right control-label col-form-label">Sub
                                    Total</label>
                                <div class="col-sm-8">
                                <span class="form-control" id="subtotal"
                                      style="cursor: not-allowed;">{{ $order->subtotal }}</span>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="fname"
                                       class="col-sm-4 text-right control-label col-form-label">Delivery</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" value="{{ $order->delivery_charge }}"
                                           id="deliveryCharge">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="fname"
                                       class="col-sm-4 text-right control-label col-form-label">Discount</label>
                                <div class="col-sm-8">
                                    <input type="text" value="{{ $order->discount_charge }}" class="form-control"
                                           id="discountCharge">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="fname"
                                       class="col-sm-4 text-right control-label col-form-label">Total</label>
                                <div class="col-sm-8">
                                    <span class="form-control" id="total"
                                          style="cursor: not-allowed;">{{ $order->total }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">

                    <button type="button" style="width: 100%;padding: 8px;font-size: 22px;" id="btn-update"
                            value="{{ $order->id }}"
                            class="btn btn-block btn-primary"><i class="fa fa-save"></i> Update Order
                    </button>

                </div>


            </div>
        </div>
    </div>

    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        var token = $("input[name='_token']").val();

        //order edit
        $("#productID").select2({
            placeholder: "Select a Product",
            dropdownParent: $('#productTable'),
            allowClear: true,
            templateResult: function (state) {
                if (!state.id) {
                    return state.text;
                }
                var $state = $(
                    '<span><img width="60px" src="' + state.image + '" class="img-flag" /> ' + state.text + '" (Size: "' + state.size + ")</span>"
                );
                return $state;
            },
            ajax: {
                type: 'GET',
                url: '{{ route('admin.products-for-purchase') }}',
                processResults: function (data) {
                    return {
                        results: data.data
                    };
                }
            }
        }).trigger("change").on("select2:select", function (e) {
            $("#productTable tbody").append(
                "<tr>" +
                '<td style="display: none">' +
                '<input type="hidden" id="prd" value="new">' +
                '<input type="text" class="productID" style="width:80px;" value="' + e.params.data.id + '">' +
                '<input type="hidden" class="sizeID" value="' + e.params.data.size_id + '">' +
                '</td>' +
                '<td><input readonly type="text" name="color" id="ProductColor" value="' + e.params.data.color + '" style="    max-width: 60px;"><br><img src="' + e.params.data.image + '" style="width:60px;margin-top:6px;"> </td>' +
                '<td><input type="text" name="size" id="ProductSize" value="' + e.params.data.size + '" readonly style="    max-width: 40px;"></td>' +
                '<td><span class="productCode">' + e.params.data.productCode + '</span></td>' +
                '<td><span class="productName">' + e.params.data.text + '</span><br></td>' +
                '<td><input type="number" class="productQuantity form-control" style="width:80px;" value="1"></td>' +
                '<td><input type="text" name="productPrice" class="productPrice" value="' + e.params.data.productPrice + '" style="max-width: 60px;"></td>' +
                '<td><button class="btn btn-sm btn-danger delete-btn"><i class="fa fa-trash"></i></button></td>\n' +
                "</tr>"
            );
            calculation();
            $('#productID').val(null).trigger('change');

        });


        $(document).on("change", ".productQuantity", function () {
            calculation();
        });
        $(document).on("input", ".productPrice", function () {
            calculation();
        });

        $(document).on("input", "#deliveryCharge", function () {
            calculation();
        });
        $(document).on("input", "#discountCharge", function () {
            calculation();
        });
        calculation();

        function calculation() {
            var subtotal = 0;
            var deliveryCharge = +$("#deliveryCharge").val();
            var discountCharge = +$("#discountCharge").val();
            $("#productTable tbody tr").each(function (index) {
                subtotal = subtotal + +$(this).find(".productPrice")
                    .val() * +$(this).find(".productQuantity").val();
            });
            $("#subtotal").text(subtotal);
            $("#total").text(subtotal + deliveryCharge -
                discountCharge);
        }

        $(document).on("click", ".delete-btn", function () {
            $(this).closest("tr").remove();
            calculation();
        });


        //product Update
        $(document).on("click", "#btn-update", function () {
            var id = $(this).val();
            var invoiceID = $("#invoiceID");
            var consigment_id = $("#consigment_id");
            var orderStatus = $("#orderStatus");
            var customerName = $("#customerName");
            var customerPhone = $("#customerPhone");
            var pec = $("#pec");
            var piva = $("#piva");
            var codice_fiscal = $("#codice_fiscal");
            var cap = $("#cap");
            var catasto_destinatario = $("#catasto_destinatario");
            var customerAddress = $("#customerAddress");
            var courier_tracking_link = $("#courier_tracking_link");
            var areaID = $("#areaID");
            var customerNote = $("#customerNote");
            var storeID = $("#storeID");
            var total = +$("#total").text();
            var subtotal = +$("#subtotal").text();
            var deliveryCharge = +$("#deliveryCharge").val();
            var discountCharge = +$("#discountCharge").val();
            var payment_type = $("#payment_type").val();
            var paymentID = $("#paymentID").val();
            var paymentAmount = +$("#paymentAmount").val();
            var paymentAgentNumber = $("#paymentAgentNumber").val();
            var orderDate = $("#orderDate");
            var courierID = $("#courierID");
            var cityID = +$("#cityID").val();
            var zoneID = +$("#zoneID").val();
            var memo = $("#memo").val();
            var order_status_id = $('#orderStatus').val();
            var product = [];
            var productCount = 0;

            $("#productTable tbody tr").each(function (index, value) {
                var currentRow = $(this);
                var obj = {};
                obj.productColor = currentRow.find("#ProductColor").val();
                obj.sigment = currentRow.find("#sigment").val();
                obj.productSize = currentRow.find("#ProductSize").val();
                obj.sizeID = currentRow.find(".sizeID").val();
                obj.productID = currentRow.find(".productID").val();
                obj.productCode = currentRow.find(".productCode").text();


                if (currentRow.find("#ProductSize").val() == '' && currentRow.find("#prd").val() == 'old') {
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

            if (invoiceID.val() == '') {
                toastr.error('Invoice ID Should Not Be Empty');
                invoiceID.css('border', '1px solid red');
                return;
            }
            invoiceID.css('border', '1px solid #ced4da');

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

            if (pec.val() == '') {
                toastr.error('PEC Should Not Be Empty');
                pec.css('border', '1px solid red');
                return;
            }
            pec.css('border', '1px solid #ced4da');

            if (piva.val() == '') {
                toastr.error('P.I VA Should Not Be Empty');
                piva.css('border', '1px solid red');
                return;
            }
            piva.css('border', '1px solid #ced4da');

            if (codice_fiscal.val() == '') {
                toastr.error('Codice Fiscal Should Not Be Empty');
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

            if (catasto_destinatario.val() == '') {
                toastr.error('Catasto Destinatario Should Not Be Empty');
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

            if (courierID.val() == '') {
                toastr.error('Courier Should Not Be Empty');
                courierID.closest('.form-group').find('.select2-selection').css('border',
                    '1px solid red');
                return;
            }
            courierID.css('border', '1px solid #ced4da');

            if (productCount == 0) {
                toastr.error('Product Should Not Be Empty');
                return;
            }

            var data = {};
            data["invoiceID"] = invoiceID.val();
            data["status"] = orderStatus.val();
            data["storeID"] = storeID.val();
            data["customerName"] = customerName.val();
            data["customerPhone"] = customerPhone.val();
            data["pec"] = pec.val();
            data["piva"] = piva.val();
            data["codice_fiscal"] = codice_fiscal.val();
            data["cap"] = cap.val();
            data["catasto_destinatario"] = catasto_destinatario.val();
            data["customerAddress"] = customerAddress.val();
            data["customerNote"] = customerNote.val();
            data["total"] = total;
            data['subtotal'] = subtotal;
            data["deliveryCharge"] = deliveryCharge;
            data["discountCharge"] = discountCharge;
            data["payment_type"] = payment_type;
            data["orderDate"] = orderDate.val();
            data["courierID"] = +courierID.val();
            data["userID"] = $('#user_id').val();
            data['order_status_id'] = order_status_id
            data["products"] = product;
            $.ajax({
                type: "PUT",
                url: "{{ url('/admin/orders') }}/" + id,
                data: {
                    'data': data,
                    '_token': token
                },
                success: function (response) {

                    if (response.status === "success") {
                        toastr.success(response.message);

                        window.location.href = "{{ route('admin.order.index') }}";
                    } else {
                        toastr.error(data["message"]);
                    }
                    // orderinfotbl.ajax.reload();
                }
            });

        });
    </script>

@endpush
