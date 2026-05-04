@extends('admin.layout.app')

@push('css')

@endpush


@section('content')

    {{-- Table Starts--}}

    <form action="{{ route('admin.blog.update', $blog->id ) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-center align-items-center">
                            <h4 class="card-title mb-0">Edit Blog for <span class="fw-bolder text-primary">({{ $blog->title }})</span>
                            </h4>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="dark_logo" class="form-label">Title </label>
                                        <input type="text" class="form-control" id="title" name="title"
                                               value="{{ $blog->title ?? '' }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">
                                    <div class="mb-3">
                                        <label for="short_description" class="form-label">Short Description</label>
                                        <textarea id="short_description" name="short_description"
                                                  class="form-control">{{ $blog->short_description ?? '' }}</textarea>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">
                                    <div class="mb-3">
                                        <label for="long_description" class="form-label">Long Description</label>
                                        <textarea id="long_description" name="long_description" class="form-control"
                                                  rows="5" cols="5">{{ $blog->long_description ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">
                                    <div class="mb-3">
                                        <label for="custom_js" class="form-label">Image</label>
                                        <input type="file" class="form-control" name="image" />

                                        @isset($blog->image)
                                            <img src="{{ asset($blog->image) }}" alt="" width="100" height="100">
                                        @endisset
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">
                                    <div class="mb-3">
                                        <label for="custom_js" class="form-label">Author Name</label>
                                        <input type="text" class="form-control" name="author"
                                               value="{{ $blog->author ?? '' }}" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">
                                    <div class="mb-3">
                                        <label for="custom_js" class="form-label">Author Image</label>
                                        <input type="file" class="form-control" name="author_image"/>

                                        @isset($blog->author_image)
                                            <img src="{{ asset($blog->author_image) }}" alt="" width="100" height="100">
                                        @endisset
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">
                                    <div class="mb-3">
                                        <label for="published_date" class="form-label">Published Date</label>
                                        <input type="date" class="form-control" name="published_date"
                                               value="{{ $blog->published_date ?? '' }}" required/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">
                                    <div class="mb-3">
                                        <label for="custom_js" class="form-label">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" @if($blog->status == 1) selected @endif>Active</option>
                                            <option value="0" @if($blog->status == 0) selected @endif>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title text-center">Meta Information</h4>
                                    </div>

                                    <div class="card-body p-4">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div>
                                                    <div class="mb-3">
                                                        <label for="meta_title" class="form-label">Meta Title</label>
                                                        <input type="text" class="form-control" id="meta_title"
                                                               name="meta_title"
                                                               value="{{ $blog->meta_title ?? '' }}">
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="mb-3">
                                                        <label for="meta_description" class="form-label">Meta
                                                            Description</label>
                                                        <textarea id="meta_description" name="meta_description"
                                                                  class="form-control">{{ $blog->meta_description ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mt-3 mt-lg-0">
                                                    <div class="mb-3">
                                                        <label for="meta_keywords" class="form-label">Meta
                                                            Keywords</label>
                                                        <textarea id="meta_keywords" class="form-control"
                                                                  name="meta_keywords">{{ $blog->meta_keywords ?? '' }}</textarea>
                                                    </div>


                                                    <div class="mb-3">
                                                        <label for="meta_image" class="form-label">Meta Image</label>
                                                        <input type="file"
                                                               oninput="metaLogoImgPrev.src=window.URL.createObjectURL(this.files[0])"
                                                               class="form-control" name="meta_image">
                                                        @isset($blog->meta_image)
                                                            <div class="mt-2">
                                                                <img src="{{ asset($blog->meta_image) }}"
                                                                     id="metaLogoImgPrev" alt="" class="img-fluid"
                                                                     height="100" width="100">
                                                            </div>
                                                        @endisset
                                                    </div>
                                                </div>


                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mt-3 mt-lg-0">
                                                <div class="mb-3">
                                                    <label for="meta_keyword" class="form-label">Google Schema</label>
                                                    <textarea id="meta_keyword" class="form-control"
                                                              name="google_schema">{{ $blog->google_schema ?? '' }}</textarea>
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
            ClassicEditor.create(document.querySelector('#long_description'))
                .then(editor => {
                    jReq = editor;
                })
                .catch(error => {
                    console.error(error);
                });

        });
    </script>
@endpush
