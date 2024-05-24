<div class="community py-12">
    <div class="container">
        @include('components.headline', ['headline' => 'community'])
        <div class="row items-center">
            <div class="md:w-7/12 sm:w-full">
                <div class="community-description">
                    <p>The <a href="/community" target="_blank">TeaCode Community</a> is a community where Moroccan developers help each other and
                        evolve in an environment conducive to learning.</p>
                    <p>Founded at the end of 2020 and continue to grow, thanks to more than 1.6k members, and specially to these amazing
                        <a target="_blank" href="http://community.drissboumlik.com/p/contributors#contributors" rel="noopener">contributors</a>.</p>
                    <p>If you like to be part of it checkout <a target="_blank" href="http://community.drissboumlik.com/github" rel="noopener">Github</a>
                        and <a target="_blank" href="http://community.drissboumlik.com/join" rel="noopener">Discord</a>.</p>
                </div>
                <div class="social-icons">
                    @include('addons.social-links', ['socialLinks' => $socialLinks])
                </div>
            </div>
            <div class="md:w-5/12 sm:w-10/12 w-11/12">
                <div class="img-wrapper community-img">
                    <img class="w-full lazyload" src="{{ asset('/assets/img/teacode/compressed/teacodema.webp') }}"
                         data-src="{{ asset('/assets/img/teacode/teacodema.webp') }}"
                         alt="" width="200" height="100" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</div>
