<div class="menu nav-scroller py-2 {{ $mode . '-mode' }}">
    <div class="container">
        <div class="menu-blocks d-flex justify-content-center align-items-center">
            <div class="brand me-2">
                <a href="/" class="d-flex align-items-center">
                    <div class="logo logo-brand position-relative d-inline-block">
                        @include('components.logo-svg')
                    </div>
                </a>
            </div>
            <nav class="nav d-flex justify-content-center">
                @include('layout.header-parts.header-menu')
            </nav>
        </div>
    </div>
</div>
