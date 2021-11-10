@extends('app')

@section('content')
    <div class="container-fluid p-0">
        @include('pages.partials.about')
        <form class="image-upload" method="post" action="/posts" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control"/>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="5" cols="40" class="form-control tinymce-editor"></textarea>
            </div>
            <div class="form-group">
                <label>Author Name</label>
                <input type="text" name="auther_name" class="form-control"/>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-success btn-sm">Save</button>
            </div>
        </form>
    </div>


    @include('layout.footer')
@endsection
