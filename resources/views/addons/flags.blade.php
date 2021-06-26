<div class="flags">
    @if (\App::getLocale() != 'fr')
        <a href="/resume/fr" class="flag-link">
            <div class="flag flag-fr d-block">fr</div>
        </a>
    @endif
    @if (\App::getLocale() != 'en')
        <a href="/resume/en" class="flag-link">
            <div class="flag flag-en d-block">en</div>
        </a>
    @endif
</div>
