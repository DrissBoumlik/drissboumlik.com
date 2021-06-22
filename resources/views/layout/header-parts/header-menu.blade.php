<ul class="header-menu list-group list-group-horizontal align-items-start mt-3">
    @foreach ($data->headerMenu as $link)
        @if (!isset($link->hidden) || !$link->hidden)
            <li class="header-menu-item list-group-item overflow-auto my-2 mx-2">
                <a href="/{{ $link->slug }}" rel="noopener" target="{{ $link->target ?? '_self' }}"
                    aria-label="{{ $link->title }}" class="text-capitalize">
                    {{ $link->title }}
                </a>
            </li>
        @endif
    @endforeach
</ul>
