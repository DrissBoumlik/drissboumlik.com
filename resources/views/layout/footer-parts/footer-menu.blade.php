<div class="footer-menu-wrapper menu-wrapper container w-100 py-2">
    <div class="row">
        <div class="col-12 col-md-8 col-lg-8 offset-md-2 offset-lg-2">
            <ul class="footer-menu menu list-group list-group-horizontal align-items-start">
                @foreach ($footerMenu as $link)
                    <li class="footer-menu-item menu-item list-group-item
                        overflow-auto animated-underline">
                        <a href="{{ $link->slug }}" rel="noopener" target="{{ $link->target ?? '_self' }}"
                            aria-label="{{ $link->title }}" class="text-capitalize">
                            {{ $link->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
