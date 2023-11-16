<div class="header-menu-wrapper menu-wrapper">
    <ul class="header-menu menu list-group list-group-horizontal">
        @foreach ($data->headerMenu as $link)
            <li class="header-menu-item menu-item list-group-item animated-underline
                    overflow-auto my-2 mx-2 {{ request()->is($link->slug) ? 'active' : '' }}">
                <a href="{{ \URL::to($link->slug) }}" rel="noopener" target="{{ $link->target ?? '_self' }}"
                    aria-label="{{ $link->title }}" class="text-capitalize">
                    {!! $link->title !!}
                </a>
            </li>
        @endforeach
        @auth
            <li class="header-menu-item menu-item list-group-item overflow-auto my-2 mx-2">
                <a href="/admin" rel="noopener" target="_blank"
                   aria-label="Admin Panel">
                    <i class="fa-solid fa-gear"></i>
                </a>
            </li>
            <li class="header-menu-item menu-item list-group-item overflow-auto my-2 mx-2">
                @include('components.logout-button', ['logout_btn' => '<i class="fa-solid fa-power-off"></i>', 'link_classes' => ''])
            </li>
        @endauth
    </ul>
</div>
