@extends('layout.page-content-wide')

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
                                <p>I'm <span class="fw-bold tc-blue">Driss Boumlik</span>, from Morocco,
                                    I <a href="/github" target="_blank" rel="noopener">code</a>,
                                    <a href="/blog">blog</a>,
                                    <a href="https://www.youtube.com/watch?v=nvW3WST6p3M"
                                       target="_blank" rel="noopener">speak</a>,
                                    <a href="https://www.apprentus.com/in/drissboumlik" rel="noopener"
                                       target="_blank" rel="noopener">teach</a>,
                                    <a href="https://www.codementor.io/@drissboumlik" rel="noopener"
                                       target="_blank">mentor</a> ...
                                    and other stuff usually not in the same order.</p>
                                <p>I like to build & share things that add value or make positive impact.</p>
                                <p>If am not in front of my laptop, I play soccer once
                                    a week in reality, and everyday
                                    <a target="_blank" href="https://rawg.io/@cartouche/games" rel="noopener">virtually</a>,
                                    otherwise I watch <a target="_blank" href="https://anilist.co/user/cartouche/animelist"
                                                         rel="noopener">anime</a>
                                    and <a target="_blank" href="https://trakt.tv/users/cartouche01/progress"
                                           rel="noopener">tv shows</a>, listen to
                                    <a target="_blank" href="https://castbox.fm/cl/360626">podcasts</a> or read
                                    <a target="_blank" href="https://www.goodreads.com/review/list/170245827-driss?view=covers"
                                       rel="noopener">books</a>.</p>
                                <p>Checkout my <a href="/resume">resume</a> and reach me through :
                                    <a href="mailto:hi@drissboumlik.com">hi@drissboumlik.com</a></p>
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
