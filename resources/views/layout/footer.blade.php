<footer class="page-footer">
    <div class="container-fluid p-0 footer text-center">
        @include('layout.footer-parts.footer-menu', ['footerMenu' => $footerMenu])
        <hr class="footer-separator">
{{--        @include('layout.footer-parts.extra-data')--}}
{{--        <hr class="footer-separator">--}}
        @include('layout.footer-parts.copy-right')
    </div>
</footer>
