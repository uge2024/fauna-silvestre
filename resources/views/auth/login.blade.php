@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="row w-100 justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg" style="border-radius: 10px; overflow: hidden; background-color: #1e1e1e; border: 1px solid #444; max-width: 400px; margin: 0 auto;">
                <div class="card-header text-center" style="background-color: #e86d53; color: #fff; padding: 1.5rem;">
                    <h3>{{ __('Login') }}</h3>
                </div>

                <div class="card-body" style="padding: 2rem; background-color: #333;">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="email" class="form-label" style="color: #ccc; font-size: 1.25rem;">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus style="border: 1px solid #555; padding: 1rem; font-size: 1.25rem; background-color: #fff; color: #000;">
                            @error('email')
                            <span class="invalid-feedback" role="alert" style="color: #ff6b6b;">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="password" class="form-label" style="color: #ccc; font-size: 1.25rem;">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" style="border: 1px solid #555; padding: 1rem; font-size: 1.25rem; background-color: #fff; color: #000;">
                            @error('password')
                            <span class="invalid-feedback" role="alert" style="color: #ff6b6b;">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="transform: scale(1.25); background-color: #444; border-color: #555;">
                                <label class="form-check-label" for="remember" style="color: #ccc; font-size: 1.25rem;">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div class="form-group mb-4 d-grid gap-2">
                            <button type="submit" class="btn text-white" style="background-color: #ff073a; padding: 1rem; font-size: 1.25rem; border: none; border-radius: 5px;">
                                {{ __('Login') }}
                            </button>
                        </div>

                        <div class="text-center">
                            @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}" style="color: #e86d53; font-size: 1.25rem;">
                                {{ __('Forgot Your Password?') }}
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection