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
                            <div class="col-md-6 col-sm-12 about-me-txt">
                                <p>I'm <span class="fw-bold tc-blue">Driss Boumlik</span>, from Morocco, I code, blog, speak, teach, mentor ...
                                    and other stuff usually not in the same order.</p>
                                <p>I like to build & share things that add value or make positive impact.</p>
                                <p>I play soccer twice a week in reality, and everyday
                                    <a target="_blank" href="https://rawg.io/@cartouche/games">virtually</a>,
                                    otherwise I watch <a target="_blank" href="https://anilist.co/user/cartouche/animelist">anime</a>
                                    and <a target="_blank" href="https://trakt.tv/users/cartouche01/progress">tv shows</a>.</p>
                                <p>You can reach me through : <a href="mailto:hi@drissboumlik.com">hi@drissboumlik.com</a></p>
                            </div>
                            <div class="col-md-6 col-sm-10 col-11">
                                <div class="img-wrapper">
                                    <img class="img-fluid" src="https://community.drissboumlik.com/assets/img/activities/coding-challenges.svg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
