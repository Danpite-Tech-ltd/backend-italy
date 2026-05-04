@extends('frontend.content.dashboard.layout.app')

@push('css')

    <style>
        a {
            text-decoration: none;
            font-weight: 600;
        }
    </style>
@endpush


@section('content')

    <div class="main-content">
        <!-- Content Header -->
        <div class="content-header">
            <h2 class="mb-0">Withdraw/Cash Out History</h2>
            {{--            <p class="mb-0">Your order list items</p>--}}
        </div>

        <!-- Main Content Area -->
        <div class="p-4">
            <div class="section-content">
                <div class="row">
                    <div class="col-12">
                        <div class="card dashboard-table mt-0">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div class="top-sec mb-4">
                                        <h3>Cash Out History</h3>
                                    </div>
                                    <div>
                                        <a href=" {{ route('affiliate-withdrawal-page') }}" class="btn btn-primary">
                                            Withdraw Request
                                        </a>
                                    </div>
                                </div>

                                <div class="table-responsive-lg">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr class="table-head">
                                            <th scope="col">SL</th>
                                            <th scope="col">Invoice Id</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($withdrawals as $key => $withdrawal)
                                            <tr>
                                                <td>
                                                    {{$loop->iteration}}
                                                </td>
                                                <td>
                                                    <p>{{$withdrawal->invoiceID}}</p>
                                                </td>
                                                <td>
                                                    {{ $withdrawal->amount }} Tk
                                                </td>

                                                <td>
                                                    {{ $withdrawal->created_at->format('d-m-Y') }}
                                                </td>

                                                <td>
                                                    @if($withdrawal->status == 0)
                                                    <span class="badge bg-secondary">
                                                        Pending
                                                    </span>
                                                    @elseif($withdrawal->status == 1)
                                                    <span class="badge bg-success">
                                                        Approved
                                                    </span>
                                                    @elseif($withdrawal->status == 2)
                                                    <span class="badge bg-danger">
                                                        Declined
                                                    </span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <a href="javascript:void(0);">
                                                        <i class="fa fa-eye text-theme"></i>
                                                    </a>
                                                </td>
                                            </tr>
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


@section('js')

@endsection

