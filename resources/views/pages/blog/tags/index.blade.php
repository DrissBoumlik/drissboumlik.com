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
        <div class="tags">
            @foreach ($tags as $tag)
                <a href="/blog/tags/{{ $tag->slug }}">
                        <span style="background-color: {{ $tag->color }}"
                              class="fs-sm fw-semibold d-inline-block py-1 px-3 mb-2
                                        rounded-pill text-white">{{ $tag->name }} ({{ $tag->posts_count }})</span>
                </a>
            @endforeach
        </div>
        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center push">
                @if ($data->tags_data['lastPage'] != 1)
                    @for ($i = 1; $i <= $data->tags_data['lastPage']; $i++)
                        <li class="page-item {{ $data->tags_data['currentPage'] == $i ? 'active' : '' }}">
                            <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                        </li>
                    @endfor
                @endif
            </ul>
        </nav>
        <!-- END Pagination -->
    </div>
    <!-- END Page Content -->
@endsection
