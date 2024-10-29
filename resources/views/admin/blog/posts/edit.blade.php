@extends('admin.template.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link href="{{ asset('/template/assets/js/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/template/assets/js/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

@endsection
@section('js')
    <script defer src="{{ asset('/template/assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script defer src="{{ asset('/template/assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
    <script defer src="{{ asset('/plugins/tinymce/tinymce.min.js') }}"></script>
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
                <form action="/admin/posts/{{ $post->slug }}" method="POST" enctype="multipart/form-data"
                      id="edit-post" class="edit-form">
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
                                <textarea id="post_excerpt" class="form-control" name="post_excerpt" placeholder="Post excerpt.." rows="4" >{{ $post->excerpt }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" placeholder="Post description.." rows="4" >{{ $post->description }}</textarea>
                            </div>
                            <div class="timestamps d-flex align-items-center column-gap-2">
                                <div class="mb-4 w-100">
                                    <label class="form-label" for="updated_at">Updated at</label>
                                    <input type="text" class="form-control" id="updated_at" disabled name="updated_at" value="{{ $post->updated_at }}" data-enable-time="true" data-time_24hr="true">
                                </div>
                                <div class="mb-4 w-100">
                                    <label class="form-label" for="created_at">Created at</label>
                                    <input type="text" class="form-control" id="created_at" disabled name="created_at" value="{{ $post->created_at }}" data-enable-time="true" data-time_24hr="true">
                                </div>
                            </div>
                            <div class="mb-4">
                                <button type="button" class="btn btn-secondary me-1 w-100 btn-view-post-assets">
                                    <i class="fa fa-fw fa-images"></i> View assets
                                </button>
                            </div>
                            <div class="">
                                <label class="form-label" for="storage">Storage path</label>
                                <input type="text" class="form-control" id="storage" disabled value="/storage/blog/posts/SLUG/assets/post_asset_KEY--compressed.WEBP">
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
                                <label class="form-label" for="post-views">Views</label>
                                <input type="number" class="form-control" id="post-views" name="views" min="0"
                                       placeholder="Post views" value="{{ $post->views }}">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="published_at">Published at</label>
                                <input type="text" class="js-flatpickr form-control" id="published_at" name="published_at" value="{{ $post->published_at }}" data-enable-time="true" data-time_24hr="true">
                            </div>
                            <div class="mb-4">
                                <div class="form-check form-switch form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="published" name="published" {{ $post->published == 0 ? '' : 'checked' }} >
                                    <label class="form-check-label" for="published">Published</label>
                                </div>
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
                                    <img id="image-preview" class="image-preview img-fluid w-100 lazyload"
                                         src="{{ $post->cover ? "/" . $post->cover->compressed : asset('/assets/img/default/missing.webp') }}"
                                         data-src="{{ $post->cover ? "/" . $post->cover->original : asset('/assets/img/default/missing.webp') }}"
                                         alt="photo" width="200" height="100" loading="lazy">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="post-assets">Post assets</label>
                                <input type="file" id="post-assets" name="post-assets[]" multiple class="form-control" />
                            </div>
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" id="append-to-post-assets" name="append-to-post-assets" checked>
                                <label class="form-check-label" for="append-to-post-assets">Append to post assets</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="block block-rounded block-bordered block-mode-hidden">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title"><label class="form-label" for="post_body">Content</label></h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                                    </div>
                                </div>
                                <div class="block-content p-0">
                                    <!-- SimpleMDE Container -->
                                    {{-- <textarea class="js-simplemde" id="simplemde" name="post_body">{{ old('post_body') }}</textarea> --}}
                                    <textarea id="post_body" class="form-control" name="post_content" placeholder="Post content.." hidden>{!! $post->content !!}</textarea>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between gap-2 flex-wrap flex-md-nowrap">
                                <button type="submit" class="btn-action btn btn-success w-100">
                                    <i class="fa fa-fw fa-edit me-1"></i>Update</button>
                                <a href="/blog/{{ $post->slug }}?forget=1" target="_blank" class="btn btn-dark w-100">
                                    <i class="fa fa-fw fa-eye me-1"></i>View</a>
                                @if($post->deleted)
                                    <button type="submit" class="btn-action btn btn-secondary w-100" name="restore">
                                        <i class="fa fa-fw fa-rotate-left me-1"></i> Restore</button>
                                @else
                                    <button type="submit" class="btn-action btn btn-warning w-100" name="delete">
                                        <i class="fa fa-fw fa-trash me-1"></i> Delete</button>
                                @endif
                                <button type="submit" class="btn-action btn btn-danger w-100" name="destroy">
                                    <i class="fa fa-fw fa-trash me-1"></i>Hard Delete</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Page Content -->

    @include('admin.addons.alert-box')
@endsection
