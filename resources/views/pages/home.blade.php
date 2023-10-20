@extends('layout.app')

@section('content')
    @php
        if (!isset($data) || $data == null) {
            $data = new \stdClass();
        }

        $data->socialLinks = getSocialLinks();
        $data->headerMenu = getHeaderMenu();
        $data->footerMenu = getFooterMenu();
    @endphp
    @include('pages.partials.about')
    <div class="container-fluid p-0">
        <div class="sections">
            <div class="section">
                <div class="posts">
                    <div class="section py-5">
                        <div class="container">
                            <div class="row section-header">
                                <div class="col-md-10 offset-md-1 col-12 d-flex flex-column align-items-center justify-content-center">
                                    <hr class="section-title-line">
                                    <h1 class="section-title">{{ $data->headline }}</h1>
                                </div>
                            </div>
                            <div class="row">
                                @foreach ($posts as $post)
                                    <div class="col-12 col-lg-6 col-xl-6 mb-4">
                                        @include('components.post', ['post' => $post])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section">
                @include('pages.resume.sections.recommendations', ['recommendations' => $data->sections['recommendations']])
            </div>
        </div>
    </div>

    @include('layout.footer')
@endsection
