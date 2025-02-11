@extends('layout.page-content-wide')

@section('post-header-assets')
    @vite(['resources/sass/_imports/pages/_about.sass'])
@endsection

@section('headline')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h1 class="header-txt">{!! $data->headline !!}</h1>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid">
        <div class="about-page about section py-5">
            <div class="py-5" id="about">
                <div class="section">
                    <div class="container">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-lg-6 col-md-7 col-12 about-me-txt">
                                <p>I'm <span class="fw-bold tc-blue">Driss Boumlik</span>, a developer from Morocco,
                                    I enjoy creating and sharing things that add value and make a positive impact,
                                    whether through <a href="http://github.com/drissboumlik" target="_blank" rel="noopener">code</a>,
                                    <a href="/blog">blog</a>, or <a href="https://www.codementor.io/@drissboumlik" rel="noopener"
                                    target="_blank">mentoring</a> others...
                                    and other stuff usually not in the same order.</p>
                                <p>
                                    When am not in front of my laptop, you’ll probably find me playing soccer once
                                    a week in reality, and sometimes
                                    <a target="_blank" href="https://rawg.io/@cartouche/games" rel="noopener">virtually</a>,
                                    watching <a target="_blank" href="https://anilist.co/user/cartouche/animelist" rel="noopener">anime</a>
                                    or <a target="_blank" href="https://trakt.tv/users/cartouche01/progress"
                                           rel="noopener">tv shows</a>, listening to
                                    <a target="_blank" href="https://castbox.fm/cl/360626">podcasts</a> or reading
                                    <a target="_blank" href="https://www.goodreads.com/review/list/170245827-driss?view=covers"
                                       rel="noopener">books</a>.
                                </p>
                                <p>You can checkout my <a href="/cv" target="_blank">resume</a> and reach out to me through
                                    <span class="tc-blue">hi@drissboumlik.com</span></p>
                            </div>
                            <div class="col-lg-6 col-md-5 col-11">
                                <div class="img-wrapper">
                                    <img class="img-fluid w-100 lazyload"
                                         src="{{ asset('/assets/img/activities/compressed/coding-challenges.webp') }}"
                                         data-src="{{ asset('/assets/img/activities/coding-challenges.svg') }}"
                                         alt="Coding Challenge" width="300" height="300" loading="lazy">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
