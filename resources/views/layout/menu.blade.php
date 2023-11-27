<div class="menu nav-scroller py-2">
    <div class="container">
        <div class="menu-blocks d-flex justify-content-center align-items-center">
            <div class="brand turn-trigger me-2 d-none d-sm-block">
                <a href="/" class="d-flex align-items-center">
                    <div class="logo logo-brand turn position-relative d-inline-block">
                        @include('components.logo-svg')
                    </div>
                </a>
            </div>
            <nav class="nav d-flex justify-content-center">
                <div class="header-menu-wrapper menu-wrapper">
                    <ul class="header-menu list-group list-group-horizontal">
                        @foreach ($headerMenu as $link)
                            <li class="header-menu-item menu-item list-group-item animated-underline
                                        overflow-auto {{ request()->is($link->slug) ? 'active' : '' }}">
                                <a href="{{ \URL::to($link->slug) }}" rel="noopener" target="{{ $link->target ?? '_self' }}"
                                   aria-label="{{ $link->title }}" class="text-capitalize">
                                    {!! $link->title !!}
                                </a>
                            </li>
                        @endforeach
                        @auth
                            <li class="header-menu-item menu-item list-group-item animated-underline overflow-auto">
                                <a href="/admin" rel="noopener" target="_blank"
                                   aria-label="Admin Panel">
                                    <i class="fa-solid fa-gear"></i>
                                </a>
                            </li>
                            <li class="header-menu-item menu-item list-group-item animated-underline overflow-auto">
                                @include('components.logout-button', ['logout_btn' => '<i class="fa-solid fa-power-off"></i>', 'link_classes' => ''])
                            </li>
                        @endauth
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>
