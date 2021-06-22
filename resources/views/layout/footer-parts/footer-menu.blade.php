<div class="footer-menu-wrapper container w-100 py-4">
    <div class="row">
        <div class="col-12 col-md-8 col-lg-8 offset-md-2 offset-lg-2">
            <div>
                <ul class="footer-menu list-group list-group-horizontal align-items-start">
                    @foreach ($data->footerMenu as $link)
                        @if (!isset($link->hidden) || !$link->hidden)
                            <li class="footer-menu-item list-group-item overflow-auto my-2 mx-3">
                                <a href="/{{ $link->slug }}" rel="noopener" target="{{ $link->target ?? '_self' }}"
                                    aria-label="{{ $link->title }}" class="text-capitalize">
                                    {{ $link->title }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
