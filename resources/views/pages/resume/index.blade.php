@extends('layout.app')

@section('content')

    {{-- @include('layouts.menu') --}}
    {{-- @include('addons.flags') --}}
    <div class="container-fluid p-0">
        @include('pages.resume.about')
        {{-- @include('pages.index-parts.activities') --}}
        <div class="sections">
            @foreach ($data->sections as $key => $section)
                {{-- @php $i = array_search($key,array_keys($data->sections)) @endphp --}}
                <div class="{{ $key }} section">
                    @include('pages.resume.sections.'.$key, [$key => $section])
                </div>
            @endforeach
            <div class="sections-menu">
                <ul class="sections-menu-items list-group">
                    <li class="list-group-item"><a href="/resume#experiences"><i class="fa-solid fa-layer-group"></i></a></li>
                    <li class="list-group-item"><a href="/resume#competences"><i class="fa-solid fa-gears"></i></a></li>
                    <li class="list-group-item"><a href="/resume#languages"><i class="fa-solid fa-language"></i></a></li>
                    <li class="list-group-item"><a href="/resume#add-skills"><i class="fa-solid fa-futbol"></i></a></li>
                    <li class="list-group-item"><a href="/resume#education"><i class="fa-solid fa-user-graduate"></i></a></li>
                    <li class="list-group-item"><a href="/resume#passion"><i class="fa-solid fa-shield-heart"></i></a></li>
                    <li class="list-group-item"><a href="/resume#other-experiences"><i class="fa-solid fa-book"></i></a></li>
                    <li class="list-group-item"><a href="/resume#recommandations"><i class="fa-solid fa-star"></i></a></li>
                </ul>
            </div>
        </div>
    </div>

    @include('layout.footer')
@endsection
