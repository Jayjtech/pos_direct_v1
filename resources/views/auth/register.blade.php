@extends('layouts.app')

@section('content')
    <h4 class="mb-2">New here?</h4>
    <h6 class="font-weight-light mb-2">Signing up is easy. It only takes a few steps</h6>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ old('name') }}" autocomplete="name" autofocus placeholder="Your name" />

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <input type="email" placeholder="Email" id="email"
                class="form-control form-control-lg @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" autocomplete="email">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <input type="password" id="password"
                class="form-control form-control-lg @error('password') is-invalid @enderror" name="password"
                autocomplete="new-password"placeholder="Password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <input id="password-confirm" type="password" class="form-control form-control-lg " name="password_confirmation"
                autocomplete="new-password"placeholder="Confirm Password">
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                {{ __('SIGN UP') }}
            </button>
        </div>

        <div class="text-center mt-4 font-weight-light">
            {{ __('Already have an account?') }} <a href="{{ route('login') }}" class="text-primary">{{ __('LOGIN') }}</a>
        </div>
    </form>
@endsection
