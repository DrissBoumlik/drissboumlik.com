@extends('app')

@section('content')

    {{-- @include('layouts.menu') --}}
    <div class="container-fluid p-0">
        @include('pages.partials.about')
        {{-- @include('pages.index-parts.activities') --}}
        <div class="sections">
            {{-- @foreach ($data->sections as $key => $section)
            @php $i = array_search($key,array_keys($data->sections)) @endphp
            <div class="{{ $key }} section {{ $i%2 == 0 ? 'tc-grey-light-bg' : 'tc-white-bg' }}" style="height: 500px">
                @include('pages.sections.'.$key, [$key => $section])
            </div>
            @endforeach --}}
            @include('pages.sections.competences', ['competences' => $data->sections['competences']])
        </div>
            {{-- @include('pages.sections.competences', ['competences' => $data->competences])
            @include('pages.sections.experiences', ['experiences' => $data->experiences])
            @include('pages.sections.education', ['education' => $data->education])
            @include('pages.sections.portfolio', ['portfolio' => $data->portfolio])
            @include('pages.sections.certificates', ['certificates' => $data->certificates])
            @include('pages.sections.passion', ['passion' => $data->passion])
            @include('pages.sections.other_exp', ['other_exp' => $data->other_exp])
            @include('pages.sections.recommandations', ['recommandations' => $data->recommandations])
            @include('pages.sections.lets_talk', ['lets_talk' => $data->lets_talk]) --}}
    </div>

    @include('layout.footer')
@endsection
