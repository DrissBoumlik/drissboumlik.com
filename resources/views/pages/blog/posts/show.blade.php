@extends('layout.page-content')

@section('page-content-header')
    <div class="post-page">
        <div class="post-cover" style="background-image: url('/{{ $post->cover }}')"></div>
    </div>
@endsection

@section('page-content')
    <livewire:post :post="$post" />
@endsection
