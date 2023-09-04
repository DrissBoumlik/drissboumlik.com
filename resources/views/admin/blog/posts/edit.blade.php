@extends('admin.template.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
{{--    <link rel="stylesheet" href="/template/assets/js/plugins/cropperjs/cropper.min.css">--}}
    <link rel="stylesheet" href="{{ asset('/template/assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/laraberg/css/laraberg.css') }}">
{{--    <link rel="stylesheet" href="/template/assets/js/plugins/simplemde/simplemde.min.css">--}}
@endsection
@section('js')
    <script src="{{ asset('/vendor/laraberg/js/react.production.min.js') }}"></script>
    <script src="{{ asset('/vendor/laraberg/js/react-dom.production.min.js') }}"></script>
    <script src="{{ asset('/vendor/laraberg/js/laraberg.js') }}"></script>
{{--    <script src="/template/assets/js/plugins/cropperjs/cropper.min.js"></script>--}}
    <script src="{{ asset('/template/assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
{{--    <script src="/template/assets/js/plugins/simplemde/simplemde.min.js"></script>--}}
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        Edit Post
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Post</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Edit
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
                <form action="/admin/posts/{{ $post->slug }}" method="POST" class="" enctype="multipart/form-data" id="edit-post">
                    @method('put')
                    @csrf
                    <div class="row items-push">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <label class="form-label" for="post-title">Title</label>
                                <input type="text" class="form-control input-to-slugify" id="post-title" name="title"
                                    placeholder="Post Title" value="{{ $post->title }}">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="post-slug">Slug</label>
                                <input type="text" class="form-control input-slug" id="post-slug" name="slug"
                                    placeholder="Post slug" value="{{ $post->slug }}">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="post_excerpt">Excerpt</label>
                                <textarea id="post_excerpt" class="form-control laraberg-textarea" name="post_excerpt" placeholder="Post excerpt.." rows="4" >{{ $post->excerpt }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Post description..">{{ $post->description }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label class="form-label" for="tags">Tags</label>
                                <select class="js-select2 form-select" id="tags-list"
                                    name="tags[]" style="width: 100%;" data-placeholder="Choose many.."
                                    multiple>
                                    <option></option>
                                    <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    @foreach ($data->tags as $tag)
                                        <option value="{{ $tag->id }}" {{ $tag->linked ? 'selected' : '' }}>{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="status">Status</label>
                                <select class="js-select2 form-select" id="status"
                                    name="status" style="width: 100%;" data-placeholder="Choose many..">
                                    <!-- Required for data-placeholder attribute to work with Select2 plugin -->

                                    @foreach(getPostStatus() as $key => $status)
                                        <option value="{{ $key }}" {{ $post->status->value == $key ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <div class="form-check form-switch form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="featured" name="featured" {{ $post->featured == 0 ? '' : 'checked' }} >
                                    <label class="form-check-label" for="featured">Featured</label>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="form-check form-switch form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="active" name="active" {{ $post->active ? 'checked' : '' }} >
                                    <label class="form-check-label" for="active">Active</label>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="image">Image</label>
                                <input type="file" id="image" name="cover" class="form-control" />
                                <div class="mt-2">
                                    <img id="image-preview" class="img-fluid" src="/{{ $post->cover }}" alt="photo">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="form-label" for="post_body">Content</label>
                                <!-- SimpleMDE Container -->
                                {{-- <textarea class="js-simplemde" id="simplemde" name="post_body">{{ old('post_body') }}</textarea> --}}
                                <textarea id="post_body" class="form-control laraberg-textarea" name="post_content" placeholder="Post content.." hidden>{!! $post->content !!}</textarea>
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <button type="submit" class="btn btn-success me-1 mb-3">
                                <i class="fa fa-fw fa-edit me-1"></i> Update
                            </button>
                            <a href="/blog/{{ $post->slug }}" target="_blank" class="btn btn-dark me-1 mb-3">
                                <i class="fa fa-fw fa-eye me-1"></i> View
                            </a>
                            <button type="submit" class="btn btn-danger me-1 mb-3" name="destroy">
                                <i class="fa fa-fw fa-trash me-1"></i> Hard Delete
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Page Content -->

    @include('admin.addons.alert-box')
@endsection
