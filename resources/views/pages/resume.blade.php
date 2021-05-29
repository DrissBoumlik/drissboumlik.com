@extends('app')

@section('content')

    {{-- @include('layouts.menu') --}}
    <div class="container-fluid p-0">
        @include('pages.partials.about')
        {{-- @include('pages.index-parts.activities') --}}
        <div class="sections">
            @foreach ($data->sections as $key => $section)
            @php $i = array_search($key,array_keys($data->sections)) @endphp
            <div class="{{ $key }} section {{ $i%2 == 0 ? 'tc-grey-light-bg' : 'tc-white-bg' }}">
                @include('pages.sections.'.$key, [$key => $section])
            </div>
            @endforeach
        </div>
    </div>

    @include('layout.footer')
@endsection
