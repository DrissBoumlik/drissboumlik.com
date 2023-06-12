
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
        $('.alert.alert-dismissible').on('click', function() { $(this).remove() });
    </script>
@endif
