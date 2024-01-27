<div class="header-menu menu nav-scroller py-2">
    <div class="container">
        <div class="menu-blocks d-flex align-items-center">
            <nav class="nav d-flex justify-content-center flex-grow-1">
                <div class="header-menu-wrapper menu-wrapper">
                    <ul class="header-menu-container list-group list-group-horizontal">
                        @foreach ($headerMenu as $link)
                            <li class="header-menu-item menu-item list-group-item animated-underline {{ request()->is($link->slug) ? 'active' : '' }}">
                                <a href="{{ \URL::to($link->slug) }}" rel="noopener" target="{{ $link->target ?? '_self' }}"
                                   aria-label="{{ $link->title }}" class="text-capitalize">
                                    {!! $link->title !!}
                                </a>
                            </li>
                        @endforeach
                        @if(request()->is(['blog', 'tags', 'search']))
                            <li class="header-menu-item menu-item list-group-item animated-underline">
                                <span class="display-search-form"><i class="fa-solid fa-magnifying-glass"></i></span>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>
            @auth
            <div class="header-menu-wrapper login-menu-items flex-grow-2">
                <ul class="header-menu-container list-group list-group-horizontal">
                    <li class="header-menu-item menu-item list-group-item animated-underline">
                        <a href="/admin" rel="noopener" aria-label="Admin Panel">
                            <i class="fa-solid fa-gear"></i>
                        </a>
                    </li>
                    <li class="header-menu-item menu-item list-group-item animated-underline">
                        @include('components.logout-button', ['logout_btn' => '<i class="fa-solid fa-power-off"></i>', 'link_classes' => ''])
                    </li>
                </ul>
            </div>
            @endauth
        </div>
    </div>
</div>
