@extends('layout.template.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="/template/assets/js/plugins/cropperjs/cropper.min.css">
    <link rel="stylesheet" href={{ asset("/template/assets/js/plugins/select2/css/select2.min.css") }}>
    <link rel="stylesheet" href="{{ asset('/vendor/laraberg/css/laraberg.css') }}">
@endsection
@section('js')
    <script src="https://unpkg.com/react@17.0.2/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@17.0.2/umd/react-dom.production.min.js"></script>
    <script src="{{ asset('/vendor/laraberg/js/laraberg.js') }}"></script>
    <script src="/template/assets/js/plugins/cropperjs/cropper.min.js"></script>
    <script src={{ asset("/template/assets/js/plugins/select2/js/select2.full.min.js") }}></script>
@endsection

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
                <form action="/admin/posts/{{ $data->post->slug }}" method="POST" class="" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="row items-push">
                        <div class="col-xxl-8">
                            <div class="mb-4">
                                <label class="form-label" for="post-title">Title</label>
                                <input type="text" class="form-control input-to-slugify" id="post-title" name="title"
                                    placeholder="Post Title" value="{{ $data->post->title }}">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="post-slug">Slug</label>
                                <input type="text" class="form-control input-slug" id="post-slug" name="slug"
                                    placeholder="Post slug" value="{{ $data->post->slug }}">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="post_body">Content</label>
                                <!-- SimpleMDE Container -->
                                {{-- <textarea class="js-simplemde" id="simplemde" name="post_body">{{ old('post_body') }}</textarea> --}}
                                <textarea id="post_body" name="post_body" placeholder="Textarea content.." hidden>{!! $data->post->content !!}</textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="excerpt">Excerpt</label>
                                <textarea class="form-control" id="excerpt" name="excerpt" rows="4" placeholder="Post excerpt..">{{ $data->post->excerpt }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="image">Image</label>
                                <input type="file" id="image" name="image" class="form-control" />
                            </div>
                        </div>
                        <div class="col-xxl-4">
                            <div class="mb-4">
                                <label class="form-label" for="tags">Tags</label>
                                <select class="js-select2 form-select" id="tags"
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
                                <label class="form-label" for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Post description..">{{ $data->post->description }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="status">Status</label>
                                <select class="js-select2 form-select" id="status"
                                    name="status" style="width: 100%;" data-placeholder="Choose many..">
                                    <option></option>
                                    <!-- Required for data-placeholder attribute to work with Select2 plugin -->

                                    @foreach(getPostStatus() as $key => $status)
                                        <option value="{{ $key }}" {{ $data->post->status->value == $key ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <div class="form-check form-switch form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="featured" name="featured" {{ $data->post->featured == 0 ? '' : 'checked' }} >
                                    <label class="form-check-label" for="featured">Featured</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12">

                            <button type="submit" class="btn btn-success me-1 mb-3">
                                <i class="fa fa-fw fa-edit me-1"></i> Update
                            </button>
                            <button type="submit" name="delete" class="btn btn-danger me-1 mb-3">
                                <i class="fa fa-fw fa-trash me-1"></i> Delete
                            </button>
                            <a href="/blog/{{ $data->post->slug }}" class="btn btn-dark me-1 mb-3">
                                <i class="fa fa-fw fa-eye me-1"></i> View
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Page Content -->

    @php $response = session()->get('response') @endphp
    @if ($response)
        <!-- END Page Content -->
        <div data-notify="container" class="col-11 col-sm-4 alert {{ $response['class'] }} alert-dismissible animated fadeIn" role="alert" data-notify-position="bottom-right" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1033; bottom: 20px; right: 20px; animation-iteration-count: 1;">
            <p class="mb-0">
                <span data-notify="icon"></span>
                <span data-notify="title"></span>
                <span data-notify="message">{{ $response['message'] }}</span>
            </p>
            <a class="p-2 m-1 text-dark" href="javascript:void(0)" aria-label="Close" data-notify="dismiss" style="position: absolute; right: 10px; top: 5px; z-index: 1035;">
                <i class="fa fa-times"></i>
            </a>
        </div>
        <script>
            $('.alert-info').on('click', function() { $(this).remove() });
        </script>
    @endif
@endsection
