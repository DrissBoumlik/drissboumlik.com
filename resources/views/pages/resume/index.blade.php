@extends('layout.app')

@section('post-header-assets')
    <script src="{{ asset('/js/pages/home.js') }}"></script>
@endsection

@section('content')
    @include('layout.menu')
    <div class="container-fluid p-0">
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
