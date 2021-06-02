<div class="copy-right-wrapper container w-100 py-5">
    <div class="row">
        <div class="col-lg-6 offset-lg-3 col-12 copyright-txt">
            <div class="copy-right">
                <span class="copy-right-txt d-none">
                    <i class="far fa-copyright"></i> Driss Boumlik {{ now()->year }}. All rights reserved
                </span>
            </div>
        </div>
        <div class="col-lg-6 offset-lg-3 col-12 owner">
            <p>
                Made with
                <span class="heart-icon"><i class="fas fa-heart"></i></span>
                by
                <span class="bold">
                    <a class="link-undecorated" href="https://linkedin.com/in/drissboumlik" target="_blank" rel="noopener">Driss Boumlik</a>
                </span>
            </p>

            {{-- <div class="social-icons-wrapper d-none">
                <ul class="list-group list-group-horizontal align-items-start">
                    @foreach ($data->socialLinks->mine as $socialLink)
                        <li class="list-group-item border-0 overflow-auto my-0 mx-2">
                            <a href="{{ $socialLink->link }}" target="_blank" rel="noopener"
                                aria-label="{{ $socialLink->title }}"
                                class="text-decoration-none">
                                <span class="social-icon">{!! $socialLink->icon !!}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div> --}}
        </div>
    </div>
</div>
