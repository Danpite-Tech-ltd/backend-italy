@extends('frontend.content.dashboard.layout.app')

@push('css')


@endpush


@section('content')

    <div class="main-content">
        <!-- Content Header -->
        <div class="content-header">
            <h2 class="mb-0">Orders</h2>
            <p class="mb-0">Your order list items</p>
        </div>

        <!-- Main Content Area -->
        <div class="p-4">
            <div class="section-content">
                <div class="row">
                    <div class="col-12">
                        <div class="card dashboard-table mt-0">
                            <div class="card-body">
                                <div class="top-sec">
                                    <h3>My Orders</h3>
                                </div>

                                <div class="table-responsive-lg">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr class="table-head">
                                            <th scope="col">SL</th>
                                            <th scope="col">Invoice Id</th>
                                            <th scope="col">Product Details</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">View</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($orders as $key => $order)
                                            <tr>
                                                <td>
                                                    {{$loop->iteration}}
                                                </td>
                                                <td>
                                                    <p>{{$order->invoiceID}}</p>
                                                </td>
                                                <td>
                                                    @forelse($order->orderProducts as $product)
                                                        <p class="fs-6 mb-1">{{$product->product_name}}
                                                            X{{$product->quantity}}</p>

                                                            <p>Variant: <span
                                                                    class="text-primary">{{$product->variant}}</span>
                                                            </p>

                                                            <p>Color: <span
                                                                    class="text-primary">{{$product->color}}</span>
                                                            </p>


                                                </td>
                                                <td>
                                                    <span class="badge rounded-pill bg-danger custom-badge">{{ $order->orderStatus->status_name }}</span>
                                                </td>
                                                <td>
                                                    <p class="theme-color fs-6"> {{$order->total}} </p>
                                                </td>
                                                <td>
                                                    <a href="">
                                                        <i class="fa fa-eye text-theme"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse


                                        @empty

                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


{{--@push('js')--}}

{{--@endpush--}}

