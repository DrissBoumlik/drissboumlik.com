<div class="menu nav-scroller py-2">
    <div class="container">
        <div class="menu-blocks d-flex justify-content-center align-items-center">
            <nav class="nav d-flex justify-content-center">
                <div class="header-menu-wrapper menu-wrapper">
                    <ul class="header-menu list-group list-group-horizontal">
                        @foreach ($headerMenu as $link)
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
            </nav>
        </div>
    </div>
</div>
