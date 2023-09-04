<div class="header-menu-wrapper menu-wrapper">
    <ul class="header-menu menu list-group list-group-horizontal align-items-start">
        @foreach ($data->headerMenu as $link)
            <li class="header-menu-item menu-item list-group-item animated-underline
                    overflow-auto my-2 mx-2 {{ request()->is($link->slug) ? 'active' : '' }}">
                <a href="/{{ $link->slug }}" rel="noopener" target="{{ $link->target ?? '_self' }}"
                    aria-label="{{ $link->title }}" class="text-capitalize" wire:navigate>
                    {{ $link->title }}
                </a>
            </li>
        @endforeach
        @auth
            <li class="header-menu-item menu-item list-group-item animated-underline overflow-auto my-2 mx-2">
                <a href="/admin" rel="noopener" target="_blank"
                   aria-label="Admin Panel" class="text-capitalize" wire:navigate>
                    <i class="fa fa-fw fa-user-shield tc-blue-dark-1"></i> Admin Panel
                </a>
            </li>
        @endauth
    </ul>
</div>
