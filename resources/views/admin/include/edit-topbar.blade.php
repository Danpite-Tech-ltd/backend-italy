<div class="row">
    <div class="col-12">
        <!-- Nav tabs -->

        <div class="card-body">

            <ul class="nav nav-pills nav-justified">
                <li class="nav-item waves-effect waves-light">
                    <a href="{{ route('admin.product.edit', $id) }}" class="nav-link  @if (Route::currentRouteName() == 'admin.product.edit') active @endif ">
                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                        <span class="d-none d-sm-block">Basic Information</span>
                    </a>
                </li>

                <li class="nav-item waves-effect waves-light">
                    <a href="{{ route('admin.pro-variant-page', $id) }}" class="nav-link  @if (Route::currentRouteName() == 'admin.pro-variant-page') active @endif ">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block">Variant Information</span>
                    </a>
                </li>
            </ul>

        </div>
    </div>

</div>
