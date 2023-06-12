@extends('layout.template.backend')

@section('css')
@endsection
@section('js')
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        Form Editors
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Text editing at its finest.
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Forms</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Editors
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="block-content">
                <form action="/admin/tags/{{ $data->tag->slug }}" method="POST" class="" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="row items-push">
                        <div class="col-xxl-8 offset-xxl-2">
                            <div class="mb-4">
                                <label class="form-label" for="tag-name">Name</label>
                                <input type="text" class="form-control input-to-slugify" id="tag-name" name="name"
                                    placeholder="Tag Name" value="{{ $data->tag->name }}">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="tag-slug">Slug</label>
                                <input type="text" class="form-control input-slug" id="tag-slug" name="slug"
                                    placeholder="Tag slug" value="{{ $data->tag->slug }}">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Tag description..">{{ $data->tag->description }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="tag-color">Color</label>
                                <input type="color" class="form-control" id="tag-color" name="color"
                                       placeholder="Tag color" value="{{ $data->tag->color }}">
                            </div>
                        </div>
                        <div class="col-xxl-8 offset-xxl-2">
                            <button type="submit" class="btn btn-success me-1 mb-3">
                                <i class="fa fa-fw fa-edit me-1"></i> Update
                            </button>
                            <button type="submit" name="delete" class="btn btn-danger me-1 mb-3">
                                <i class="fa fa-fw fa-trash me-1"></i> Delete
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Page Content -->

    @php $response = session()->get('response') @endphp
    @if ($response)
        <!-- END Page Content -->
        <div data-notify="container" class="col-11 col-sm-4 alert {{ $response['class'] }} alert-dismissible animated fadeIn" role="alert" data-notify-position="bottom-right" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1033; bottom: 20px; right: 20px; animation-iteration-count: 1;">
            <p class="mb-0">
                <span data-notify="icon"></span>
                <span data-notify="title"></span>
                <span data-notify="message">{{ $response['message'] }}</span>
            </p>
            <a class="p-2 m-1 text-dark" href="javascript:void(0)" aria-label="Close" data-notify="dismiss" style="position: absolute; right: 10px; top: 5px; z-index: 1035;">
                <i class="fa fa-times"></i>
            </a>
        </div>
        <script>
            $('.alert-info').on('click', function() { $(this).remove() });
        </script>
    @endif
@endsection
