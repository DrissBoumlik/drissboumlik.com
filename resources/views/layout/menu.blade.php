<div class="header-menu menu nav-scroller py-2">
    <header>
        <div class="container">
            <div class="menu-blocks d-flex align-items-center">
                <nav class="nav d-flex justify-content-center flex-grow-1">
                    <div class="header-menu-wrapper menu-wrapper">
                        <ul class="header-menu-container list-group list-group-horizontal">
                            @foreach ($headerMenu as $link)
                                <li class="header-menu-item menu-item list-group-item animated-underline
                                        {{ request()->is($link->link, ltrim($link->link, '/')) ? 'active' : '' }}">
                                    <a href="{{ $link->link }}" rel="noopener" target="{{ $link->target ?? '_blank' }}"
                                       aria-label="{{ $link->title }}" class="text-capitalize" title="{{ $link->title }}">
                                        {!! $link->text !!}
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
                    <div class="header-menu-wrapper auth-menu-items flex-grow-2">
                        <ul class="header-menu-container list-group">
                            <li class="header-menu-item menu-item list-group-item animated-underline">
                                <a href="?{{ http_build_query(request()->merge([ "forget" => true ])->query()) }}"
                                    aria-label="Reload" title="Reload" id="hard-reload">
                                    <i class="fa-solid fa-rotate-right"></i>
                                </a>
                            </li>
                            @if (isGuest(session()->get('guest-view')))
                                <li class="header-menu-item menu-item list-group-item animated-underline">
                                    <a href="?{{ http_build_query(request()->merge([ "guest-view" => -1, "forget" => true ])->query()) }}"
                                        rel="noopener" aria-label="Admin View" title="Back to Admin view">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </a>
                                </li>
                            @else
                                <li class="header-menu-item menu-item list-group-item animated-underline">
                                    <a href="?{{ http_build_query(request()->merge([ "guest-view" => 1, "forget" => true ])->query()) }}"
                                       rel="noopener" aria-label="Guest View" title="Switch to Guest view">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </li>
                            @endif
                            <li class="header-menu-item menu-item list-group-item animated-underline">
                                <a href="/admin" rel="noopener" aria-label="Admin Panel" title="Admin Panel">
                                    <i class="fa-solid fa-gear"></i>
                                </a>
                            </li>
                            <li class="header-menu-item menu-item list-group-item animated-underline">
                                @include('components.logout-button',
                                        ['logout_btn' => '<i class="fa-solid fa-power-off"></i>', 'link_classes' => ''])
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>
        </div>
    </header>
</div>
