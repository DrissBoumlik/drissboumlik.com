<div class="social-icons-wrapper">
    <ul class="list-group list-group-horizontal align-items-start">
        @foreach ($socialLinks as $socialLink)
            <li class="list-group-item border-0 py-0 px-2">
                <a href="{{ \URL::to($socialLink->link) }}" target="{{ $socialLink->target ?? '_blank' }}" rel="noopener"
                    aria-label="{{ $socialLink->title }}" title="{{ $socialLink->title }}"
                    class="text-decoration-none">
                    <span class="social-icon">{!! $socialLink->icon !!}</span>
                </a>
            </li>
        @endforeach
    </ul>
</div>
