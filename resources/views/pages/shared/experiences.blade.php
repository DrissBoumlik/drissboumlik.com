<div class="py-5" id="experiences">
    <div class="section experiences">
        <div class="container">
            @include('components.headline', ['headline' => 'experiences'])
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
                                        @if (isset($experience->content->items) && is_array($experience->content->items))
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
                                            <div class="underline">Technical environment :</div>
                                            <div class="tech-env-items">
                                                @foreach($experience->techs as $tech)
                                                    <span class="tech-tag tag">{!! $tech->title !!}</span>
                                                @endforeach
                                                </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
