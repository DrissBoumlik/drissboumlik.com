@extends('layout.page-content-wide')

@section('headline')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h1 class="header-txt">{!! $data->headline !!}</h1>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid p-0">
        <div class="get-in-touch section py-5">
            <div class="py-5" id="get-in-touch">
                <div class="section">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                                <form id="contact-form" class="mb-4">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="form-name" placeholder="" name="name" required />
                                        <label for="form-name">Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="form-email" placeholder="" name="email" required />
                                        <label for="form-email">Email address</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" id="form-body" rows="3" name="body" placeholder="" required maxlength="1000"></textarea>
                                        <label for="form-body">Message</label>
                                    </div>
                                    <button type="submit" class="btn tc-blue-dark-2-bg tc-blue-bg-hover w-100">Send</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
