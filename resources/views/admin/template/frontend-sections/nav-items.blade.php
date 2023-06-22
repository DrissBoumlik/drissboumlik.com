<ul class="{{ $nav_class }}">
    @auth
        <li class="nav-main-item">
            <a class="nav-main-link" href="/admin">
                <span class="nav-main-link-name">Admin Panel</span>
            </a>
        </li>
    @endauth
    <li class="nav-main-item">
        <a class="nav-main-link {{ request()->is('') ? 'active' : '' }}" href="/">
            <span class="nav-main-link-name">Home</span>
        </a>
    </li>
    <li class="nav-main-item">
        <a class="nav-main-link {{ request()->is('blog') ? 'active' : '' }}" href="/blog">
            <span class="nav-main-link-name">Blog</span>
        </a>
    </li>
    <li class="nav-main-item">
        <a class="nav-main-link {{ request()->is('tags') ? 'active' : '' }}" href="/tags">
            <span class="nav-main-link-name">Tags</span>
        </a>
    </li>
    <li class="nav-main-item">
        <a class="nav-main-link {{ request()->is('about') ? 'active' : '' }}" href="/about">
            <span class="nav-main-link-name">About</span>
        </a>
    </li>
    <li class="nav-main-item">
        <a class="nav-main-link {{ request()->is('resume') ? 'active' : '' }}" href="/resume" target="_blank">
            <span class="nav-main-link-name">Resume</span>
        </a>
    </li>

</ul>
