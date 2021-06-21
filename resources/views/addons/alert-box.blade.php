@if(Session::has('status'))
    <div class="alert-box">
        <div class="alert alert-success {{ Session::get('class') }}" role="alert">
            {{ Session::get('status') }}
        </div>
        <div class="alert-close pointer">
            <i class="far fa-times-circle"></i>
        </div>
    </div>
@endif
