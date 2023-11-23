<div class="community py-5">
    <div class="container">
        @include('components.headline', ['headline' => 'community'])
        <div class="row align-items-center">
            <div class="col-md-7 col-sm-12">
                <div class="community-description">
                    <p>The <a href="/community" target="_blank">TeaCode Community</a> is a community where Moroccan developers help each other and
                        evolve in an environment conducive to learning.</p>
                    <p>Founded at the end of 2020 and continue to grow, thanks to more than 1.6k members, and specially to these amazing
                        <a target="_blank" href="http://community.drissboumlik.com/p/contributors#contributors">contributors</a>.</p>
                    <p>If you like to be part of it checkout <a target="_blank" href="http://community.drissboumlik.com/github">Github</a>
                        and <a target="_blank" href="http://community.drissboumlik.com/join">Discord</a>.</p>
                </div>
                <div class="social-icons">
                    @include('addons.social-links', ['socialLinks' => $socialLinks])
                </div>
            </div>
            <div class="col-md-5 col-sm-10 col-11">
                <div class="img-wrapper">
                    <img class="img-fluid w-100" src="{{ asset('/assets/img/work/teacodema.webp') }}" alt="" width="200" height="100" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</div>
