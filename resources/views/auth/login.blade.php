@extends('layouts.app')

@section('content')
    <h6 class="font-weight-light mb-2">Sign in to continue.</h6>
    <form method="post" class="pt-3" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control form-control-lg @error('email') is-invalid @enderror"
                id="exampleInputEmail1" name="email" value="{{ old('email') }}" autocomplete="email" autofocus
                placeholder="Username or Email">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                id="exampleInputPassword1" name="password" autocomplete="current-password" placeholder="Password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                {{ __('SIGN IN') }}</button>
        </div>

        <div class="my-2 d-flex justify-content-between align-items-center">
            <div class="form-check">
                <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }} />
                    {{ __('Keep me signed in') }}
                </label>
            </div>

            @if (Route::has('password.request'))
                <a class="auth-link text-black" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}</a>
            @endif
        </div>

        <div class="text-center mt-4 font-weight-light">
            {{ __("Don't have an account?") }} <a href="{{ route('register') }}"
                class="text-primary">{{ __('SIGN UP') }}</a>
        </div>
    </form>
@endsection
