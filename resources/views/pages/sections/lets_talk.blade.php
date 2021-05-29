<div class="section contact-me" id="contact-me">
    <div class="container">
        <div class="row">
            <hr class="section-title-line">
            <h1 class="section-title uppercase">{{ $lets_talk->header }}</h1>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <ul class="list-group">
                        @foreach ($lets_talk->items as $lets_talkItem)
                            <li class="list-group-item">
                                <a href="{{ $lets_talkItem->href . (isset($lets_talkItem->lang) ? ($lets_talkItem->lang ? '/' . \App::getLocale() : '') : '') }}" target="_blank">
                                    <img src="{{ $lets_talkItem->icon }}" alt="">
                                </a>
                            </li>
                        @endforeach
                    <!-- <li class="list-group-item"><a href="https://facebook.com/boumlikdriss" target="_blank">
                                <img src="../../img/social/facebook.png" alt="">
                            </a></li>
                        <li class="list-group-item"><a href="https://instagram.com/drissboumlik" target="_blank">
                                <img src="../../img/social/instagram.png" alt="">
                            </a></li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
