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
                        Create Tag
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Tags</a>
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
                <form action="/admin/tags" method="POST" class="" enctype="multipart/form-data">
                    @csrf
                    <div class="row items-push">
                        <div class="col-md-6 offset-md-3">
                            <div class="mb-4">
                                <label class="form-label" for="tag-name">Name</label>
                                <input type="text" class="form-control input-to-slugify" id="tag-name" name="name"
                                    placeholder="Tag Name" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="tag-slug">Slug</label>
                                <input type="text" class="form-control input-slug" id="tag-slug" name="slug"
                                    placeholder="Tag slug" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Tag description.."></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="tag-color">Color</label>
                                <input type="color" class="form-control" id="tag-color" name="color"
                                       placeholder="Tag color">
                            </div>
                            <div class="mb-4">
                                <div class="form-check form-switch form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="active" name="active" >
                                    <label class="form-check-label" for="active">Active</label>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="image">Image</label>
                                <input type="file" id="image" name="cover" class="form-control" />
                                <div class="mt-2">
                                    <img id="image-preview" class="img-fluid image-preview w-100"
                                         src="{{ asset('/assets/img/default/landscape.webp') }}"
                                         alt="photo" width="200" height="100" loading="lazy">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-success me-1 mb-3 w-100"><i class="fa fa-fw fa-plus me-1"></i>Submit</button>
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
