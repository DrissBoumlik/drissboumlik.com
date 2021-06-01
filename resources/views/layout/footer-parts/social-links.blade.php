<div class="social-icons-wrapper">
    <ul class="list-group list-group-horizontal align-items-start">
        @foreach ($data->socialLinks as $socialLink)
            @if (!isset($socialLink->hidden) || !$socialLink->hidden)
                <li class="list-group-item border-0 overflow-auto my-0 mx-2">
                    <a href="/{{ $socialLink->link }}/{{ (!isset($socialLink->local) || !$socialLink->local) ? '' : \App::getLocale() }}" target="_blank" rel="noopener"
                        aria-label="{{ $socialLink->title }}"
                        target="{{ $link->target ?? '_self' }}"
                        class="text-decoration-none">
                        <span class="social-icon">{!! $socialLink->icon !!}</span>
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</div>
