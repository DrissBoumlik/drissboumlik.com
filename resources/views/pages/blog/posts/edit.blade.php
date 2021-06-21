@extends('app')

@section('header-assets')
<script src="https://unpkg.com/react@16.8.6/umd/react.production.min.js"></script>
<script src="https://unpkg.com/react-dom@16.8.6/umd/react-dom.production.min.js"></script>

<link rel="stylesheet" href="{{asset('vendor/laraberg/css/laraberg.css')}}">
<script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>

@endsection

@section('content')
    <div class="container-fluid p-0">
        {{-- @include('pages.partials.about') --}}
        <div class="post-form">
            <div class="section py-5">
                <div class="container">
                    <div class="row section-header">
                        <div class="col-md-10 offset-md-1 col-12 d-flex flex-column align-items-center justify-content-center">
                            <hr class="section-title-line">
                            <h1 class="section-title">Post form</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            @include('addons.alert-box')
                            <form method="POST" action="{{ $data->route }}">
                                @csrf
                                @if (isset($data->post))
                                    @method('PUT')
                                @endif
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="post-title" name="title"
                                    value="{{ isset($data->post) ? $data->post->title : '' }}" placeholder="Post title">
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="post-slug" name="slug"
                                    value="{{ isset($data->post) ? $data->post->slug : '' }}" placeholder="Post slug">
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="post-tags" name="tags"
                                    value="{!! isset($data->post) ? ($data->post->tags ? implode(' ', $data->post->tags) : '') : '' !!}"
                                    placeholder="Post tags">
                                </div>
                                <div class="mb-3 post-body-wrapper">
                                    <div class="laraberg-sidebar">
                                        <textarea name="excerpt" id="post-excerpt" placeholder="Excerpt"></textarea>
                                    </div>
                                    <textarea id="post-body" name="body" class="form-control" hidden>{!! isset($data->post) ? $data->post->body : '' !!}</textarea>
                                </div>
                                <div class="btn-group w-100" role="group">
                                    <button type="submit" class="btn tc-blue-dark-1-bg text-white">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('layout.footer')
@endsection
