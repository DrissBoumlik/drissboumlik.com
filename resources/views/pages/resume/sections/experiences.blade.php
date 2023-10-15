<div class="py-5">
    <div class="section experiences" id="experiences">
        <div class="container">
            <div class="row section-header">
                <div class="col-md-10 offset-md-1 col-12 d-flex flex-column align-items-center justify-content-center">
                    <hr class="section-title-line">
                    <h1 class="section-title">experiences</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="timeline">
                        @foreach ($experiences->items as $experience)
                            <div class="section {{ $experience->classList }}">
                                <div class="content">
                                    <h2 class="function text-capitalize">{{ $experience->job }}</h2>
                                    <h2 class="where text-uppercase">{{ $experience->company }}</h2>
                                    <span><i class="fa-solid fa-calendar-days"></i> {{ $experience->period }} |
                                        {!! $experience->duration !!}
                                    </span>
                                    @if ($experience->content)
                                        <hr class="my-2">
                                        @isset($experience->content->headline) {!! $experience->content->headline !!} @endisset
                                        @if(isset($experience->content->items) && is_array($experience->content->items))
                                            <ul>
                                            @foreach($experience->content->items as $item)
                                                <li>{!! $item !!}</li>
                                            @endforeach
                                            </ul>
                                        @endif
                                    @endif
                                    @if (isset($experience->techs) && is_array($experience->techs))
                                        <hr class="my-2">
                                        <div class="tech-env">
                                            <p><span class='underline'>Technical environment :</span><br/>
                                                @foreach($experience->techs as $tech)
                                                    <span data-toggle="tooltip" data-placement="bottom" title="{{ $tech->title }}">{!! $tech->content !!}</span>
                                                @endforeach
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                    <!-- <div class="section code rotated freelance">
                            <div class="content">
                                <h2 class="where uppercase">Freelance</h2>
                                <h2 class="function">Full Stack Developer</h2>
                                <span><i class="far fa-calendar-alt"></i> Jan 2018 |
                                    <?php // echo calculateDate("2018-01");?>
                        </span>
                        <p>After an unforgettable experience as a programming teacher for children,
                            I decided to switch back to programming and code.</p>
                    </div>
                </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
