@extends('admin.template.backend')


@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        Form Editors
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Text editing at its finest.
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Forms</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Editors
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
                        <div class="col-xxl-8 offset-xxl-2">
                            <div class="mb-4">
                                <label class="form-label" for="tag-name">Name</label>
                                <input type="text" class="form-control input-to-slugify" id="tag-name" name="name"
                                    placeholder="Tag Name">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="tag-slug">Slug</label>
                                <input type="text" class="form-control input-slug" id="tag-slug" name="slug"
                                    placeholder="Tag slug">
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
                                <label class="form-label" for="image">Image</label>
                                <input type="file" id="image" name="cover" class="form-control" />
                                <div class="mt-2">
                                    <img id="image-preview" class="img-fluid" src="" alt="photo">
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-8 offset-xxl-2">
                            <button type="submit" class="btn btn-success me-1 mb-3">
                                <i class="fa fa-fw fa-plus me-1"></i> Submit
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
