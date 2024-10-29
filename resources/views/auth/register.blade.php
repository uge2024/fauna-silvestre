@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="row w-100 justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg" style="border-radius: 10px; overflow: hidden; background-color: #1e1e1e; border: 1px solid #444; max-width: 400px; margin: 0 auto;">
                <div class="card-header text-center" style="background-color: #ff073a; color: #fff; padding: 1.5rem;">
                    <h3>{{ __('Register') }}</h3>
                </div>

                <div class="card-body" style="padding: 2rem; background-color: #333;">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="name" class="form-label" style="color: #ccc; font-size: 1.25rem;">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus style="border: 1px solid #555; padding: 1rem; font-size: 1.25rem; background-color: #fff; color: #000;">
                            @error('name')
                                <span class="invalid-feedback" role="alert" style="color: #ff6b6b;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="email" class="form-label" style="color: #ccc; font-size: 1.25rem;">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" style="border: 1px solid #555; padding: 1rem; font-size: 1.25rem; background-color: #fff; color: #000;">
                            @error('email')
                                <span class="invalid-feedback" role="alert" style="color: #ff6b6b;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="password" class="form-label" style="color: #ccc; font-size: 1.25rem;">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" style="border: 1px solid #555; padding: 1rem; font-size: 1.25rem; background-color: #fff; color: #000;">
                            @error('password')
                                <span class="invalid-feedback" role="alert" style="color: #ff6b6b;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="password-confirm" class="form-label" style="color: #ccc; font-size: 1.25rem;">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" style="border: 1px solid #555; padding: 1rem; font-size: 1.25rem; background-color: #fff; color: #000;">
                        </div>

                        <div class="form-group mb-4 d-grid gap-2">
                            <button type="submit" class="btn text-white" style="background-color: #ff073a; padding: 1rem; font-size: 1.25rem; border: none; border-radius: 5px;">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
