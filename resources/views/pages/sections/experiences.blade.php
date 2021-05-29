<div class="section experiences" id="experiences">
    <div class="container">
        <div class="row">
            <hr class="section-title-line">
            <h1 class="section-title uppercase">experiences</h1>
        </div>
        <div class="row">
            <div class="timeline">
                @foreach ($experiences->items as $experience)
                    <div class="section {{ $experience->classList }} rotated">
                        <div class="content">
                            <h2 class="where uppercase">{{ $experience->company }}</h2>
                            <h2 class="function">{{ $experience->job }}</h2>
                            <span><i class="far fa-calendar-alt"></i> {{ $experience->period }} |
                                {!! calculateDate($experience->start_date, $experience->end_date) !!}
                            </span>
                            <hr class="mgtb-10">
                            {!! $experience->content !!}
                            <hr class="mgtb-10">
                            {!! $experience->techs !!}
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
