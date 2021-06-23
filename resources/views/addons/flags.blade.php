<div class="flags">
    <div class="flag flag-fr {{ \App::getLocale() == 'fr' ? 'd-none' : 'd-block' }}">
        <a href="/resume?lang=fr">fr</a>
    </div>
    <div class="flag flag-en {{ \App::getLocale() == 'en' ? 'd-none' : 'd-block' }}">
        <a href="/resume?lang=en">en</a>
    </div>
</div>
