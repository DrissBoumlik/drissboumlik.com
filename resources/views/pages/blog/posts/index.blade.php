@extends('admin.template.frontend')


@section('content')
    <!-- Hero Content -->
    <div class="bg-image" style="background-image: url('/assets/img/blog/default.jfif');">
        <div class="bg-primary-dark-op">
            <div class="content content-full text-center pt-7 pb-6">
                <h1 class="h2 text-white mb-2">
                    The latest stories only for you.
                </h1>
                <h2 class="h4 fw-normal text-white-75 mb-0">
                    Feel free to explore and read.
                </h2>
            </div>
        </div>
    </div>
    <!-- END Hero Content -->

    <!-- Page Content -->
    <div class="content content-boxed">
        <div class="row">
            @foreach ($posts as $post)
                <!-- Story -->
                <div class="col-md-4 col-sm-6">
                    <a class="block block-rounded block-link-pop overflow-hidden" href="/blog/{{ $post['slug'] }}">
                        <div class="post-image">
                            <img class="img-fluid" src="/{{ $post['image'] }}" alt="">
                        </div>
                        <div class="block-content">
                            <h4 class="mb-1">{{ $post['title'] }}</h4>
                            <p class="fs-sm fw-medium mb-2">
                                <span class="text-primary">{{ $post['author']->name }}</span> · {{ $post['published_at'] }} · <span class="text-muted">10 min</span>
                            </p>
                            <p class="fs-sm text-muted">
                                {!! $post['excerpt'] ?? \Str::limit($post['content'], 20); !!}
                            </p>
                        </div>
                    </a>
                </div>
                <!-- END Story -->
            @endforeach
        </div>
        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center push">
                @if ($data->posts_data['lastPage'] != 1)
                    @for ($i = 1; $i <= $data->posts_data['lastPage']; $i++)
                        <li class="page-item {{ $data->posts_data['currentPage'] == $i ? 'active' : '' }}">
                            <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                        </li>
                    @endfor
                @endif
                {{-- <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" aria-label="Next">
                        <span aria-hidden="true">
                            <i class="fa fa-angle-right"></i>
                        </span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </li> --}}
            </ul>
        </nav>
        <!-- END Pagination -->
    </div>
    <!-- END Page Content -->
@endsection
