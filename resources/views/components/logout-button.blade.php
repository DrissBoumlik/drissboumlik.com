<div class="logout-btn">
    <a class="{{ $link_classes }}" href="{{ route('logout') }}" title="Logout"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        {!! $logout_btn !!}
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>
