@extends('layout.page-content-wide')

@section('headline')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h1 class="header-txt">{!! $data->headline !!}</h1>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid">
        <div class="section py-5">
            <div class="py-5" id="about">
                <div class="about-page about">
                    <div class="container">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-md-6 col-12 about-me-txt">
                                <p>I'm <span class="fw-bold tc-blue">Driss Boumlik</span>, from Morocco, I code, blog, speak, teach, mentor ...
                                    and other stuff usually not in the same order.</p>
                                <p>I like to build & share things that add value or make positive impact.</p>
                                <p>If am not in front of my laptop, I play soccer twice a week in reality, and everyday
                                    <a target="_blank" href="https://rawg.io/@cartouche/games" rel="noopener">virtually</a>,
                                    otherwise I watch <a target="_blank" href="https://anilist.co/user/cartouche/animelist" rel="noopener">anime</a>
                                    and <a target="_blank" href="https://trakt.tv/users/cartouche01/progress" rel="noopener">tv shows</a> or read
                                    <a target="_blank" href="https://www.goodreads.com/review/list/170245827-driss?view=covers" rel="noopener">books</a>.</p>
                                <p>Checkout my <a href="/resume">resume</a> and reach me through : <a href="mailto:hi@drissboumlik.com">hi@drissboumlik.com</a></p>
                            </div>
                            <div class="col-md-6 col-10 col-11">
                                <div class="img-wrapper">
                                    <img class="img-fluid w-100" src="{{ asset('/assets/img/activities/coding-challenges.svg') }}" alt="" width="300" height="300" loading="lazy">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
