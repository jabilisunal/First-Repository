@extends('admin::layouts.guest')
@section('content')
    <div class="content-wrapper">
        <div class="content d-flex justify-content-center align-items-center">
            <form class="login-form" method="post" action="{{ route('admin.login') }}">
                @csrf
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="d-flex p-2 mb-2 mt-1 justify-content-center">

                            </div>
                            <h5 class="mb-0 mt-3">Hesabınıza daxil olun</h5>
                        </div>
                        @if($errors->has('auth'))
                            <h4 class="mb-3 text-danger f-w-400">{{$errors->first('auth')}}</h4>
                        @endif
                        <div class="form-group form-group-feedback form-group-feedback-left">
                            <label for="email" class="w-100">
                                <input type="text" id="email" name="email" class="form-control" placeholder="Email">
                            </label>
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                            @if($errors->has('email'))
                                <label id="username-error" class="validation-invalid-label" for="email">{{$errors->first('email')}}</label>
                            @endif
                        </div>

                        <div class="form-group form-group-feedback form-group-feedback-left">
                            <label for="password" class="w-100">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Şifrə">
                            </label>
                            <div class="form-control-feedback">
                                <i class="icon-lock2 text-muted"></i>
                            </div>
                            @if($errors->has('password'))
                                <label id="password-error" class="validation-invalid-label" for="password">{{$errors->first('password')}}</label>
                            @endif
                        </div>

                        <div class="form-group d-flex align-items-center">
                            <div class="form-check mb-0">
                                <label class="form-check-label">
                                    <input type="checkbox" name="remember" class="form-input-styled" checked data-fouc>
                                    Xatırla
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Daxil ol <i class="icon-circle-right2 ml-2"></i></button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
