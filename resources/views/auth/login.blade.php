@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-group d-block d-md-flex row">
                <div class="card col-md-7 p-4 mb-0">
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <h1>Login</h1>
                            <p class="text-body-secondary">Sign in to your account</p>

                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <div class="input-group mb-3">
                                <span class="input-group-text">
                                    <svg class="icon"><use xlink:href="/vendor/@coreui/icons/svg/free.svg#cil-envelope-closed"></use></svg>
                                </span>
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Email"
                                    autocomplete="username"
                                    autofocus
                                    required
                                >
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="input-group mb-4">
                                <span class="input-group-text">
                                    <svg class="icon"><use xlink:href="/vendor/@coreui/icons/svg/free.svg#cil-lock-locked"></use></svg>
                                </span>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Password"
                                    autocomplete="current-password"
                                    required
                                >
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary px-4">
                                        Login
                                    </button>
                                </div>
                            </div>

                            <div class="form-check mt-3">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="remember"
                                    id="remember"
                                >
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card col-md-5 text-white bg-primary py-5">
                    <div class="card-body text-center">
                        <div>
                            <h2>ApiForge</h2>
                            <p>
                                Don't have an account yet?
                            </p>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">
                                    <button type="button" class="btn btn-lg btn-outline-light mt-3">
                                        Register Now!
                                    </button>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection