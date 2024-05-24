<div class="footer-menu-wrapper menu-wrapper container m-auto w-full py-2">
    <div class="row flex flex-wrap">
        <div class="w-full md:w-8/12 lg:w-8/12 m-auto">
            <ul class="footer-menu menu list-group flex-row flex flex-wrap justify-center items-start">
                @foreach ($footerMenu as $link)
                    <li class="footer-menu-item menu-item list-group-item overflow-auto animated-underline
                                {{ request()->is($link->slugified_title ?? $link->title) ? 'active' : '' }}">
                        <a href="{{ $link->slug }}" rel="noopener" target="{{ $link->target ?? '_self' }}"
                            aria-label="{{ $link->title }}" class="capitalize">
                            {{ $link->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
