@extends('admin.template.backend')

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
                        Edit Tag
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Tags</a>
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
                <form action="/admin/tags/{{ $tag->slug }}" method="POST" class="" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="row items-push">
                        <div class="col-md-8 offset-md-2 col-12">
                            <div class="mb-4">
                                <label class="form-label" for="example-static-input-plain">Posts tagged : {{ $tag->posts_count }}</label>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="tag-name">Name</label>
                                <input type="text" class="form-control input-to-slugify" id="tag-name" name="name"
                                    placeholder="Tag Name" value="{{ $tag->name }}" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="tag-slug">Slug</label>
                                <input type="text" class="form-control input-slug" id="tag-slug" name="slug"
                                    placeholder="Tag slug" value="{{ $tag->slug }}" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Tag description..">{{ $tag->description }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="tag-color">Color</label>
                                <input type="color" class="form-control" id="tag-color" name="color"
                                       placeholder="Tag color" value="{{ $tag->color }}">
                            </div>
                            <div class="mb-4">
                                <div class="form-check form-switch form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="active" name="active" {{ $tag->active ? 'checked' : '' }} >
                                    <label class="form-check-label" for="active">Active</label>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="image">Image</label>
                                <input type="file" id="image" name="cover" class="form-control" />
                                <div class="mt-2">
                                    <img id="image-preview" class="image-preview img-fluid lazyload" src="{{ $tag->cover ? "/" . $tag->cover->compressed : asset('/assets/img/blog/default-tag.webp') }}"
                                         data-src="{{ $tag->cover ? "/" . $tag->cover->original : asset('/assets/img/blog/default-tag.webp') }}"
                                         alt="photo" width="200" height="100" loading="lazy">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between column-gap-2 flex-wrap flex-md-nowrap">
                                <button type="submit" class="btn btn-success me-1 mb-3 w-100">
                                    <i class="fa fa-fw fa-edit me-1"></i>Update</button>
                                @if($tag->deleted)
                                    <button type="submit" class="btn btn-secondary me-1 mb-3 w-100" name="restore">
                                        <i class="fa fa-fw fa-rotate-left me-1"></i> Restore</button>
                                @else
                                    <button type="submit" class="btn btn-warning me-1 mb-3 w-100" name="delete">
                                        <i class="fa fa-fw fa-trash me-1"></i> Delete</button>
                                @endif
                                <button type="submit" class="btn btn-danger me-1 mb-3 w-100" name="destroy">
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
