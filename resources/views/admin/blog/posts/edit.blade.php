@extends('admin.template.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
{{--    <link rel="stylesheet" href="/template/assets/js/plugins/cropperjs/cropper.min.css">--}}
    <link href="{{ asset('/template/assets/js/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/template/assets/js/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
{{--    <link rel="stylesheet" href="{{ asset('/vendor/laraberg/css/laraberg.css') }}">--}}
{{--    <link rel="stylesheet" href="/template/assets/js/plugins/simplemde/simplemde.min.css">--}}
@endsection
@section('js')
{{--    <script src="{{ asset('/vendor/laraberg/js/react.production.min.js') }}"></script>--}}
{{--    <script src="{{ asset('/vendor/laraberg/js/react-dom.production.min.js') }}"></script>--}}
{{--    <script src="{{ asset('/vendor/laraberg/js/laraberg.js') }}"></script>--}}
{{--    <script src="/template/assets/js/plugins/cropperjs/cropper.min.js"></script>--}}
    <script src="{{ asset('/template/assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/template/assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>

{{--    <script src="/template/assets/js/plugins/simplemde/simplemde.min.js"></script>--}}
    <script src="{{ asset('/plugins/tinymce/tinymce.min.js') }}"></script>
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
                            <div class="mb-4">
                                <label class="form-label" for="published_at">Published at</label>
                                <input type="text" class="js-flatpickr form-control" id="published_at" name="published_at" value="{{ $post->published_at }}" data-enable-time="true" data-time_24hr="true">
                            </div>
                            <div class="timestamps d-flex justify-content-between align-items-center column-gap-2">
                                <div class="mb-4">
                                    <label class="form-label" for="updated_at">Updated at</label>
                                    <input type="text" class="js-flatpickr form-control" id="updated_at" disabled name="updated_at" value="{{ $post->updated_at }}" data-enable-time="true" data-time_24hr="true">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="created_at">Created at</label>
                                    <input type="text" class="js-flatpickr form-control" id="created_at" disabled name="created_at" value="{{ $post->created_at }}" data-enable-time="true" data-time_24hr="true">
                                </div>
                            </div>
                            <div class="post-assets">
                                <h5 class="mb-1">Post content assets</h5>
                                @isset($post->content_assets)
                                    @foreach($post->content_assets as $post_asset)
                                        <div><a href="{{ $post_asset->link }}" target="_blank">{{ $post_asset->filename }}</a></div>
                                    @endforeach
                                @endisset
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
                                        <option value="{{ $tag->id }}" {{ $tag->linked ? 'selected' : '' }}>{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="status">Status</label>
                                <select class="js-select2 form-select" id="status"
                                    name="status" style="width: 100%;" data-placeholder="Choose many..">
                                    <!-- Required for data-placeholder attribute to work with Select2 plugin -->

                                    @foreach($data->postsStatus as $key => $status)
                                        <option value="{{ $key }}" {{ $post->status->value == $key ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="post-views">Views</label>
                                <input type="text" class="form-control" id="post-views" name="views" placeholder="Post views" value="{{ $post->views }}">
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
                                <label class="form-label" for="image">Cover</label>
                                <input type="file" id="image" name="cover" class="form-control" />
                                <div class="mt-2">
                                    <img id="image-preview" class="image-preview img-fluid w-100" src="{{ $post->cover ? "/$post->cover" : asset('/assets/img/blog/default-post.webp') }}" alt="photo" width="200" height="100" loading="lazy">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="post-assets">Post assets</label>
                                <input type="file" id="post-assets" name="post-assets[]" multiple class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="form-label" for="storage">Storage path</label>
                                <input type="text" class="form-control" id="storage" disabled value="/storage/blog/posts/SLUG/assets/post_asset_KEY--compressed.WEBP">
                            </div>
                            <div class="">
                                <label class="form-label" for="post_body">Content</label>
                                <!-- SimpleMDE Container -->
                                {{-- <textarea class="js-simplemde" id="simplemde" name="post_body">{{ old('post_body') }}</textarea> --}}
                                <textarea id="post_body" class="form-control" name="post_content" placeholder="Post content.." hidden>{!! $post->content !!}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
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
