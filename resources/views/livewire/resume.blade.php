<div class="sections">
    @foreach ($data->sections as $key => $section)
        {{-- @php $i = array_search($key,array_keys($data->sections)) @endphp --}}
        <div class="{{ $key }} section">
            @include('pages.resume.sections.'.$key, [$key => $section])
        </div>
    @endforeach
</div>