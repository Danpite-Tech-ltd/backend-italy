@extends('admin.layout.app')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">
@endpush


@section('content')


    {{--    Form Starts--}}

    @if($pixel)
        <form method="post" action="{{route('admin.pixel.update',$pixel->id)}}" enctype="multipart/form-data">
            @method('PUT')

            @else
                <form method="post" action="{{route('admin.pixel.store')}}" enctype="multipart/form-data">

                    @endif

                    @csrf
                    <div class="row">

                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title text-center">Pixel Management</h4>

                                </div>
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div>
                                                <div class="mb-3">
                                                    <label for="pixel_code" class="form-label">Pixel Code</label>
                                                    <input class="form-control" type="text" name="pixel_code"
                                                           placeholder=""
                                                           id="pixel_code" value="{{ $pixel->pixel_code ?? '' }}" required>
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
