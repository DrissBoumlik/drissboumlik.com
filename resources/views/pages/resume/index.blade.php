@extends('app')

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
        </div>
    </div>

    @include('layout.footer')
@endsection
