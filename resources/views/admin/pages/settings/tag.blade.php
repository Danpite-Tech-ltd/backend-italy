@extends('admin.layout.app')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">
@endpush


@section('content')


    {{--    Form Starts--}}

    @if($tag)
        <form method="post" action="{{route('admin.tag.update',$tag->id)}}" enctype="multipart/form-data">
            @method('PUT')

            @else
                <form method="post" action="{{route('admin.tag.store')}}" enctype="multipart/form-data">

                    @endif

                    @csrf
                    <div class="row">

                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title text-center">Google Tag Manager</h4>

                                </div>
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div>
                                                <div class="mb-3">
                                                    <label for="gtm_code" class="form-label">GTM Code</label>
                                                    <input class="form-control" type="text" name="gtm_code"
                                                           placeholder="Type code here"
                                                           id="gtm_code" value="{{ $tag->gtm_code ?? '' }}" required>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="mb-3">
                                                    <button class="btn btn-primary" type="submit">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                </form>

        @endsection


        @push('js')
        @endpush
