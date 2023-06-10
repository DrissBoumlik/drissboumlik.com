@extends('layout.template.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href={{ asset("/assets/js/plugins/select2/css/select2.min.css") }}>
    <link rel="stylesheet" href="{{ asset('/vendor/laraberg/css/laraberg.css') }}">
@endsection
@section('js')
    <script src="https://unpkg.com/react@17.0.2/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@17.0.2/umd/react-dom.production.min.js"></script>
    <script src="{{ asset('/vendor/laraberg/js/laraberg.js') }}"></script>
    <script src={{ asset("/assets/js/plugins/select2/js/select2.full.min.js") }}></script>
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
            <div class="col-12">
                <div class="block-content">
                    <form action="/posts" method="POST" class="">
                        @csrf
                        <div class="mb-4">
                            <div class="mb-4">
                                <label class="form-label" for="example-text-input">Post Title</label>
                                <input type="text" class="form-control" id="example-text-input" name="title"
                                    placeholder="Post Title">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="post_body">Post Content</label>
                                <!-- SimpleMDE Container -->
                                {{-- <textarea class="js-simplemde" id="simplemde" name="post_body">{{ old('post_body') }}</textarea> --}}
                                <textarea id="post_body" name="post_body" placeholder="Textarea content.." hidden></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="excerpt">Post excerpt</label>
                                <textarea class="form-control" id="excerpt" name="excerpt" rows="4" placeholder="Post excerpt.."></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="tags">Post tags</label>
                                <select class="js-select2 form-select" id="tags"
                                    name="tags" style="width: 100%;" data-placeholder="Choose many.."
                                    multiple>
                                    <option></option>
                                    <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    <option value="1" selected>HTML</option>
                                    <option value="2" selected>CSS</option>
                                    <option value="3">JavaScript</option>
                                    <option value="4">PHP</option>
                                    <option value="5">MySQL</option>
                                    <option value="6">Ruby</option>
                                    <option value="7">Angular</option>
                                    <option value="8">React</option>
                                    <option value="9">Vue.js</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="description">Post description</label>
                                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Post description.."></textarea>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label" for="image">Post image</label>
                                <input type="file" id="image" class="form-control" />
                            </div>
                            <input type="submit" class="btn btn-secondary" value="Validate">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
