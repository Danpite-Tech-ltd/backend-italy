<div class="row">
    <div class="col-md-6">
        <div class="product-gallery product-gallery-vertical">
            <div class="row">

                <figure class="product-main-image">
                    <img id="product-zoom" src="{{ asset($loadcolor->image) }}"
                         data-zoom-image="{{ asset($loadcolor->image) }}">
                    <a href="{{ asset($loadcolor->image) }}" id="btn-product-gallery"></a>
                </figure>

                <div id="product-zoom-gallery" class="product-image-gallery">
                    @php
                        $images = $loadcolor->images ? json_decode($loadcolor->images, true) : [];
                    @endphp

                    @if(!empty($images))
                        @foreach ($images as $image)
                            <a class="product-gallery-item {{ $loop->first ? 'active' : '' }}"
                               href="javascript:void(0)"
                               data-image="{{ asset($image) }}"
                               data-zoom-image="{{ asset($image) }}">
                                <img src="{{ asset($image) }}" alt="{{ $product->name ?? '' }}">
                            </a>
                        @endforeach
                    @endif
                </div><!-- End .product-image-gallery -->
            </div><!-- End .row -->
        </div><!-- End .product-gallery -->
    </div><!-- End .col-md-6 -->

    <div class="col-md-6">
        <div class="product-details">
            <h1 class="product-title">{{$product->name}}</h1><!-- End .product-title -->

            <div class="ratings-container">
                <div class="ratings">
                    <div class="ratings-val" style="width: 100%;"></div><!-- End .ratings-val -->
                </div><!-- End .ratings -->
                <a class="ratings-text" href="#product-review-link" id="review-link">( 2 Reviews )</a>
            </div><!-- End .rating-container -->

            <div class="product-price">
                <del style="color:red;font-size:16px;">৳<span
                        id="regularprice">{{intval($loadvarient->regular_price)}}</span></del> &nbsp;<b>৳<span
                        id="saleprice">{{intval($loadvarient->sale_price)}}</span></b>
            </div><!-- End .product-price -->
            @if(isset($product->short_description))
                <div class="product-content">
                    <p>{{$product->short_description}}</p>
                </div><!-- End .product-content -->
            @endif

            @if($loadcolor->color_id == 1)
            @else
                <label class="mb-0"><b>Color:</b></label>
                <div class="mb-0 details-filter-row details-row-size">
                    <div class="product-nav product-nav-thumbs">
                        @foreach ($product->productcolors as $color)
                            <a href="javascript:void(0)"
                            class="thumb-item {{ $loadcolor->id == $color->id ? 'active' : '' }}"
                            data-id="{{ $color->id }}"
                            data-image="{{ asset($color->image) }}"
                            data-zoom-image="{{ asset($color->image) }}">
                                <img src="{{ asset($color->image) }}" alt="{{ $product->name ?? '' }}">
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif


            {{-- ===================== VARIANT SECTION ===================== --}}
            @if($loadvarient->variant_id == 1)
                <input type="hidden" value="{{ $loadvarient->id }}" name="from_varient" id="from_varient">
            @else
                <label class="mb-0"><b>Choose Variant:</b></label>
                <div class="details-filter-row details-row-size">
                    <div class="d-flex">
                        @foreach($loadvarients as $varient)
                            <a href="javascript:void(0)"
                            class="mr-2 varient {{ $loadvarient->id == $varient->id ? 'active' : '' }}"
                            data-id="{{ $varient->id }}"
                            style="{{ $varient->total_stock == 0 ? 'pointer-events:none; opacity:0.4;' : '' }}">

                                {{ $varient->variant_name }}

                                @if($varient->total_stock == 0)
                                    <span class="ml-1 badge badge-danger">Stock Out</span>
                                @endif

                            </a>
                        @endforeach
                    </div>
                </div>

                <input type="hidden" value="{{ $loadvarient->id }}" name="from_varient" id="from_varient">
            @endif



            {{-- ===================== ORDER FORM ===================== --}}
            <form action="{{ route('order-now') }}" method="post">
                @csrf

                <input type="hidden" name="variant_id" value="{{ $loadvarient->id }}" id="variant_id">


                @if($loadvarient->total_stock == 0)
                    <p class="text-danger"><b>Stock Out</b></p>
                @endif


                {{-- ===================== QTY SECTION ===================== --}}
                <div class="details-filter-row details-row-size">
                    <label for="qty">Qty:</label>
                    <div class="product-details-quantity">
                        <div class="input-group">
                            <button type="button" class="btn-qty btn-decrement d-none">-</button>
                            <input name="quantity" type="number" id="qty"
                                class="form-control" value="1" min="1" max="10" step="1"
                                data-decimals="0" required>
                            <button type="button" class="btn-qty btn-increment d-none">+</button>
                        </div>
                    </div>
                </div>


                {{-- ===================== BUTTONS ===================== --}}
                <div class="product-details-action">

                    {{-- ADD TO CART --}}
                    @if($loadvarient->total_stock == 0)
                        <a class="mb-1 btn-product btn-cart w-100 mr-lg-2"
                        style="pointer-events:none; opacity:0.4;">
                            <span>Stock Out</span>
                        </a>
                    @else
                        <a type="button" class="mb-1 btn-product btn-cart w-100 mr-lg-2"
                        id="add-to-cart-btn">
                            <span>Add to Cart</span>
                        </a>
                    @endif


                    {{-- ORDER NOW --}}
                    @if($loadvarient->total_stock == 0)
                        <button type="button" class="mb-1 btn-product btn-cart w-100"
                                style="opacity:0.4;" disabled>
                            Stock Out
                        </button>
                    @else
                        <button type="submit" class="mb-1 btn-product btn-cart w-100"
                                id="ordernow">
                            Order Now
                        </button>
                    @endif


                    <div class="details-action-wrapper">
                        <a href="javascript:void(0)" class="mb-1 btn-product btn-wishlist add-to-wishlist"
                        data-id="{{ $product->id }}" title="Wishlist">
                            <span>Add to Wishlist</span>
                        </a>
                    </div>

                </div>
            </form>

            <div class="product-details-footer">
                <div class="product-cat">
                    <span>Category:</span> <a
                        href="{{url('category',$product->category->slug)}}">{{$product->category->name}}</a>
                </div><!-- End .product-cat -->

                <div class="social-icons social-icons-sm">
                    <span class="social-label">Share:</span>
                    <a href="{{ $shareLinks['facebook'] }}"
                       class="social-icon" title="Facebook" target="_blank">
                        <i class="icon-facebook-f"></i>
                    </a>

                    <a href="{{ $shareLinks['twitter'] }}"
                       class="social-icon" title="Twitter" target="_blank">
                        <i class="icon-twitter"></i>
                    </a>

                    <a href="{{ $shareLinks['pinterest'] }}"
                       class="social-icon" title="Pinterest" target="_blank">
                        <i class="icon-pinterest"></i>
                    </a>
                    <a href="{{ $shareLinks['whatsapp'] }}"
                       class="social-icon" title="WhatsApp" target="_blank">
                        <i class="icon-whatsapp"></i>
                    </a>
                </div>
            </div><!-- End .product-details-footer -->
        </div><!-- End .product-details -->
    </div><!-- End .col-md-6 -->
</div><!-- End .row -->
<div id="ajax-loader-overlay" style="display: none;">
    <div class="spinner"></div>
</div>
<script>
    $(document).ready(function () {

        // ===========================
        // 🔹 COLOR CHANGE (AJAX)
        // ===========================
        $(".product-nav-thumbs").on("click", ".thumb-item", function (e) {
            e.preventDefault();

            $(".thumb-item").removeClass("active");
            $(this).addClass("active");

            let colorId = $(this).data("id");

            $.ajax({
                url: "{{ route('change-color') }}",
                type: "GET",
                data: { color_id: colorId },
                beforeSend: function () {
                    $("#ajax-loader-overlay").show();
                },
                success: function (response) {
                    $("#ajax-loader-overlay").hide();
                    $('.product-details-top').empty().append(response);
                    initProductGallery(); // Reinitialize for new gallery images
                },
                error: function (xhr) {
                    $("#ajax-loader-overlay").hide();
                    console.error(xhr.responseText);
                }
            });
        });


        // ===========================
        // 🔹 VARIANT CHANGE (DELEGATED)
        // ===========================
        $(document).on("click", ".varient", function (e) {
            e.preventDefault();

            $(".varient").removeClass("active");
            $(this).addClass("active");

            let variantId = $(this).data("id");
            $('#from_varient').val(variantId);

            $.ajax({
                url: "{{ route('change-variant') }}",
                type: "GET",
                data: { variant_id: variantId },
                success: function (response) {
                    $("#saleprice").text(parseInt(response.sale_price));
                    $("#regularprice").text(parseInt(response.regular_price));
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                }
            });
        });


        // ===========================
        // 🔹 ADD TO CART (DELEGATED)
        // ===========================
        $(document).on("click", "#add-to-cart-btn", function (e) {
            e.preventDefault();
            // $('.cart-count').empty()
            const mainImg = document.getElementById('product-zoom');
            const cartIcon = document.getElementById("cart-icon");
            if (!mainImg || !cartIcon) return;

            // Clone image for animation
            const flyingImg = mainImg.cloneNode(true);
            flyingImg.classList.add("flying-img");
            document.body.appendChild(flyingImg);

            const rect = mainImg.getBoundingClientRect();
            flyingImg.style.position = "fixed";
            flyingImg.style.top = rect.top + "px";
            flyingImg.style.left = rect.left + "px";
            flyingImg.style.width = rect.width + "px";
            flyingImg.style.height = rect.height + "px";
            flyingImg.style.transition = "all 0.8s ease-in-out";
            flyingImg.style.zIndex = "9999";

            // AJAX: Add to Cart
            $.ajax({
                url: "{{ route('add-to-cart') }}",
                type: "GET",
                data: {
                    variant_id: $('#from_varient').val(),
                    quantity: $('#qty').val(),
                },
                success: function (response) {
                    console.log(response.item)
                    $('.cart-count').text(response.item);
                    if (typeof loadcart === 'function') loadcart();
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                }
            });

            // Animate image toward cart icon
            const cartRect = cartIcon.getBoundingClientRect();
            setTimeout(() => {
                flyingImg.style.top = cartRect.top + "px";
                flyingImg.style.left = cartRect.left + "px";
                flyingImg.style.width = "20px";
                flyingImg.style.height = "20px";
                flyingImg.style.opacity = "0.5";
            }, 10);

            // Remove after animation
            flyingImg.addEventListener("transitionend", function () {
                flyingImg.remove();

                // const countElem = cartIcon.querySelector(".cart-count");
                // if (countElem) {
                //     countElem.textContent = parseInt(countElem.textContent) + 1;
                // }
            });
        });


        // ===========================
        // 🔹 INITIALIZE GALLERY + QTY
        // ===========================
        function initProductGallery() {
            const mainImg = document.getElementById('product-zoom');
            const galleryLink = document.getElementById('btn-product-gallery');
            const galleryItems = document.querySelectorAll('.product-gallery-item');

            // Image gallery switching
            galleryItems.forEach(item => {
                item.addEventListener('click', function (e) {
                    e.preventDefault();

                    let newImage = this.getAttribute('data-image');
                    let zoomImage = this.getAttribute('data-zoom-image');

                    if (mainImg && galleryLink) {
                        mainImg.setAttribute('src', newImage);
                        mainImg.setAttribute('data-zoom-image', zoomImage);
                        galleryLink.setAttribute('href', newImage);
                    }

                    galleryItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Quantity buttons
            const qtyInput = document.getElementById("qty");
            const btnIncrement = document.querySelector(".btn-increment");
            const btnDecrement = document.querySelector(".btn-decrement");

            if (qtyInput && btnIncrement && btnDecrement) {
                btnIncrement.addEventListener("click", function () {
                    let current = parseInt(qtyInput.value) || 1;
                    let max = parseInt(qtyInput.getAttribute("max")) || 10;
                    if (current < max) qtyInput.value = current + 1;
                });

                btnDecrement.addEventListener("click", function () {
                    let current = parseInt(qtyInput.value) || 1;
                    let min = parseInt(qtyInput.getAttribute("min")) || 1;
                    if (current > min) qtyInput.value = current - 1;
                });
            }
        }

        // Run once initially
        initProductGallery();

    });
</script>


