<div class="flags">
    @php $locale = \App::getLocale() == 'fr' ? 'en' : 'fr' @endphp
    <a href="/resume/?lang={{ $locale }}" class="flag-link">
        <div class="flag flag-{{ $locale }} d-block">{{ $locale }}</div>
    </a>
</div>
