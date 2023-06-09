@extends('layout.template.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    {{-- <link rel="stylesheet" href="/js/plugins/simplemde/simplemde.min.css"> --}}
    <link rel="stylesheet" href="{{asset('vendor/laraberg/css/laraberg.css')}}">
@endsection
@section('js')
<script src="https://unpkg.com/react@17.0.2/umd/react.production.min.js"></script>
<script src="https://unpkg.com/react-dom@17.0.2/umd/react-dom.production.min.js"></script>
{{-- <script src="/js/plugins/simplemde/simplemde.min.js"></script> --}}
<script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>
{{-- <script>One.helpersOnLoad(['js-ckeditor', 'js-simplemde']);</script> --}}
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
                                <input type="text" class="form-control" id="example-text-input"
                                    name="title" placeholder="Post Title">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="laraberg_editor">Post Content</label>
                                <!-- SimpleMDE Container -->
                                {{-- <textarea class="js-simplemde" id="simplemde" name="post_body">{{ old('post_body') }}</textarea> --}}
                                <textarea id="laraberg_editor" name="post_body" hidden></textarea>
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
