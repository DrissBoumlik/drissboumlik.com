@extends('admin.template.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
{{--    <link rel="stylesheet" href="{{ asset('/template/assets/js/plugins/cropperjs/cropper.min.css') }}">--}}
    <link href="{{ asset('/template/assets/js/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/template/assets/js/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
{{--    <link rel="stylesheet" href="{{ asset('/vendor/laraberg/css/laraberg.css') }}">--}}
@endsection
@section('js')
{{--    <script src="{{ asset('/vendor/laraberg/js/react.production.min.js') }}"></script>--}}
{{--    <script src="{{ asset('/vendor/laraberg/js/react-dom.production.min.js') }}"></script>--}}
{{--    <script src="{{ asset('/vendor/laraberg/js/laraberg.js') }}"></script>--}}
{{--    <script src="/template/assets/js/plugins/cropperjs/cropper.min.js"></script>--}}
    <script src="{{ asset('/template/assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/template/assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('/plugins/tinymce/tinymce.min.js') }}"></script>
@endsection

@section('post-header-assets')
    @vite(['resources/js/admin/pages/post.js'])
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        Create Post
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Post</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Create
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="block-content">
                <form action="/admin/posts" method="POST" class="" enctype="multipart/form-data" id="create-post">
                    @csrf
                    <div class="row items-push">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <label class="form-label" for="post-title">Title</label>
                                <input type="text" class="form-control input-to-slugify" id="post-title" name="title"
                                    placeholder="Post Title" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="post-slug">Slug</label>
                                <input type="text" class="form-control input-slug" id="post-slug" name="slug"
                                    placeholder="Post slug" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="excerpt">Excerpt</label>
                                <textarea class="form-control" id="excerpt" name="excerpt" rows="4" placeholder="Post excerpt.."></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Post description.."></textarea>
                            </div>
                            <div class="">
                                <label class="form-label" for="published_at">Published at</label>
                                <input type="text" class="js-flatpickr form-control" id="published_at" name="published_at" value="{{ now() }}" data-enable-time="true" data-time_24hr="true">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label class="form-label" for="tags-list">Tags</label>
                                <select class="js-select2 form-select" id="tags-list"
                                    name="tags[]" style="width: 100%;" data-placeholder="Choose many.."
                                    multiple>
                                    <option></option>
                                    <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    @foreach ($data->tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="status">Status</label>
                                <select class="js-select2 form-select" id="status"
                                    name="status" style="width: 100%;" data-placeholder="Choose many..">
                                    <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    @foreach($data->postsStatus as $key => $status)
                                        <option value="{{ $key }}">{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <div class="form-check form-switch form-check-inline">
                                    <input class="form-check-input" type="checkbox" value="" id="featured" name="featured" checked>
                                    <label class="form-check-label" for="featured">Featured</label>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="image">Cover</label>
                                <input type="file" id="image" name="cover" class="form-control" />
                                <div class="mt-2">
                                    <img id="image-preview" class="image-preview img-fluid w-100" src="{{ asset('/assets/img/blog/default-post.webp') }}" alt="photo" width="200" height="100" loading="lazy">
                                </div>
                            </div>
                            <div class="">
                                <label class="form-label" for="post-assets">Post assets</label>
                                <input type="file" id="post-assets" name="post-assets[]" multiple class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="">
                                <label class="form-label" for="post_body">Content</label>
                                <!-- SimpleMDE Container -->
                                {{-- <textarea class="js-simplemde" id="simplemde" name="post_body">{{ old('post_body') }}</textarea> --}}
                                <textarea id="post_body" class="form-control" name="post_content" placeholder="Post content.." hidden>Post content..</textarea>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between">
                            <button type="submit" class="btn btn-success me-1 mb-3 w-100">
                                <i class="fa fa-fw fa-plus me-1"></i>Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Page Content -->

    @include('admin.addons.alert-box')
@endsection
