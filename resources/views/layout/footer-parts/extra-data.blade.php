<div class="extra-data-wrapper container w-100 pt-5 pb-md-5 pb-4">
    <div class="row">
        <div class="col-12 col-md-8 col-lg-8 offset-md-2 offset-lg-2">
            <div class="teacode-header brand turn-trigger mb-2 d-inline-block">
                <a href="/">
                    <span class="text-uppercase brand-text">teac</span>
                    <div class="logo logo-brand position-relative d-inline-block">
                        <img src="{{ asset('/assets/img/teacode/teacode_circle_200.png') }}" width="30" height="30"
                        class="logo turn img-fluid square-25" alt="Logo">
                    </div>
                    <span class="text-uppercase brand-text">de</span>
                </a>
            </div>
            <div class="text-body">
                <p>
                    As human beings, we love bringing value to ourselves and to others.
                    Join us and level up your development skills in the process,
                    or give 15 to 30 min of your time to help others who need it, a value is added in both ways.
                </p>
            </div>

            <div class="social-icons-wrapper">
                <ul class="list-group list-group-horizontal align-items-start">
                    @foreach ($data->socialLinks as $socialLink)
                        <li class="list-group-item border-0 overflow-auto my-0 mx-2">
                            <a href="/{{ $socialLink->link }}" target="_blank" rel="noopener"
                                aria-label="{{ $socialLink->title }}"
                                class="text-decoration-none">
                                <span class="social-icon">{!! $socialLink->icon !!}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
