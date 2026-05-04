@extends('admin.layout.app')

@push('css')

@endpush


@section('content')

    {{-- Table Starts--}}

    <form action="{{ route('admin.page.update', $page->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">

                        <div class="d-flex justify-content-center align-items-center">
                            <h4 class="mb-0 card-title">Edit Page <span class="fw-bolder text-primary">({{ $page->title }})</span></h4>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <div class="mb-3">
                                        <label for="dark_logo" class="form-label">Title </label>
                                        <input type="text" class="form-control" id="title" name="title" value="{{ $page->title ?? '' }}">
                                    </div>
                                </div>
                            </div>



                            <div class="col-lg-12">
                                <div class="mt-3 mt-lg-0">
                                    <div class="mb-3">
                                        <label for="content" class="form-label">Page Content (Text Editor)</label>
                                        <textarea id="content" name="content" class="form-control" rows="5" cols="5">{{ $page->content ?? '' }}</textarea>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">
                                    <div class="mb-3">
                                        <label for="custom_css" class="form-label">Custom CSS (text)</label>
                                        <textarea id="custom_css" name="custom_css" class="form-control">{{ $page->custom_css ?? '' }}</textarea>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">
                                    <div class="mb-3">
                                        <label for="custom_js" class="form-label">Custom JS (text)</label>
                                        <textarea id="custom_js" name="custom_js" class="form-control">{{ $page->custom_js ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">
                                    <div class="mb-3">
                                        <label for="custom_js" class="form-label">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" @if($page->status == 1) selected @endif>Active</option>
                                            <option value="0" @if($page->status == 0) selected @endif>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">
                                    <div class="mb-3">
                                        <label for="custom_js" class="form-label">Position Status</label>
                                        <select name="type" id="type" class="form-control">
                                            <option value="1" @if($page->type == 1) selected @endif>Customer Support</option>
                                            <option value="0" @if($page->type == 0) selected @endif>Legal</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="text-center card-title">Meta Information</h4>
                                    </div>

                                    <div class="p-4 card-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div>
                                                    <div class="mb-3">
                                                        <label for="meta_title" class="form-label">Meta Title</label>
                                                        <input type="text" class="form-control" id="meta_title" name="meta_title"
                                                               value="{{ $page->meta_title ?? '' }}">
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="mb-3">
                                                        <label for="meta_description" class="form-label">Meta Description</label>
                                                        <textarea id="meta_description" name="meta_description"
                                                                  class="form-control">{{ $page->meta_description ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mt-3 mt-lg-0">
                                                    <div class="mb-3">
                                                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                                        <textarea id="meta_keywords" class="form-control"
                                                                  name="meta_keywords">{{ $page->meta_keywords ?? '' }}</textarea>
                                                    </div>



                                                    <div class="mb-3">
                                                        <label for="meta_image"  class="form-label" >Meta Image</label>
                                                        <input type="file" oninput="metaLogoImgPrev.src=window.URL.createObjectURL(this.files[0])" class="form-control" name="meta_image">
                                                        <div class="mt-1">
                                                            @if(isset($page->meta_image))
                                                                <img src="{{ asset($page->meta_image) }}" id="metaLogoImgPrev" alt="" class="img-fluid" height="100" width="100">
                                                            @endif
                                                        </div>
                                                    </div>




                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mt-3 mt-lg-0">
                                                    <div class="mb-3">
                                                        <label for="meta_keyword" class="form-label">Google Schema</label>
                                                        <textarea id="meta_keyword" class="form-control"
                                                                  name="google_schema">{{ $page->google_schema ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div> <!-- end col -->
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary waves-effect waves-light w-100">Save</button>
                            </div>
                        </div>

                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>

    </form>

    {{--    Table Ends--}}


@endsection


@push('js')
    <script src="{{asset('https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js')}}"></script>

    <script>

        $(document).ready(function () {

            let jReq;
            ClassicEditor.create(document.querySelector('#content'))
                .then(editor => {
                    jReq = editor;
                })
                .catch(error => {
                    console.error(error);
                });

        });
    </script>
@endpush
