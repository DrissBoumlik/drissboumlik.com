<div class="community py-5">
    <div class="container">
        @include('components.headline', ['headline' => 'community'])
        <div class="row align-items-center">
            <div class="col-md-7 col-sm-12">
                <div class="community-description">
                    <p>The <a href="/community" target="_blank">TeaCode Community</a> is a community where Moroccan
                        developers help each other and evolve in an environment conducive to learning.</p>
                    <p>Founded at the end of 2020 and continue to grow, thanks to more than 1.6k members, and specially
                        to these amazing
                        <a target="_blank" href="http://community.drissboumlik.com/p/contributors#contributors"
                           rel="noopener">contributors</a>.</p>
                    <p>If you like to be part of it checkout
                        <a target="_blank" href="http://community.drissboumlik.com/github" rel="noopener">Github</a>
                        and <a target="_blank" href="http://community.drissboumlik.com/join"
                               rel="noopener">Discord</a>.</p>
                </div>
                <div class="social-icons">
                    @include('addons.social-links', ['socialLinks' => $socialLinks])
                </div>
            </div>
            <div class="col-md-5 col-sm-10 col-11">
                <div class="img-wrapper community-img">
                    <img class="img-fluid w-100 lazyload"
                         src="{{ asset('/assets/img/teacode/compressed/teacodema.webp') }}"
                         data-src="{{ asset('/assets/img/teacode/teacodema.webp') }}"
                         alt="TeaCode Community" width="200" height="100" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</div>
