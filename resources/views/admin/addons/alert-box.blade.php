
@php $response = session()->get('response') @endphp
@if ($response)
    <div data-notify="container" class="alert {{ $response['class'] }} d-flex align-items-center alert-dismissible animated fadeIn" role="alert"
         style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1033; bottom: 20px; right: 20px; animation-iteration-count: 1;">
        <div class="flex-shrink-0">
            {!! $response['icon'] !!}
        </div>
        <div class="flex-grow-1 ms-3">
            <p class="mb-0">{{ $response['message'] }}</p>
            <a class="p-2 m-1 text-dark" href="javascript:void(0)" aria-label="Close" data-notify="dismiss" style="position: absolute; right: 10px; top: 5px; z-index: 1035;">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </div>
    <script>
        $('.alert.alert-dismissible').on('click', function() { $(this).remove() });
    </script>
@endif
