@extends('layout.app')

@section('content')

    {{-- @include('layouts.menu') --}}
    {{-- @include('addons.flags') --}}
    <div class="container-fluid p-0">
        @include('pages.resume.about')
        {{-- @include('pages.index-parts.activities') --}}
        <livewire:resume />
    </div>

    @include('layout.footer')
@endsection
