@extends('layouts.auth', ['title' => 'Sign In'])

@section('content')

<div class="col-xl-5">
    <div class="card auth-card">
        <div class="card-body px-3 py-5">

            <div class="mx-auto mb-4 text-center auth-logo">
                <a href="{{ route('home') }}" class="logo-dark">
                    <img src="/images/logo-sm.png" height="30" class="me-1" alt="logo sm">
                    <img src="/images/logo-dark.png" height="24" alt="logo dark">
                </a>

                <a href="{{ route('home') }}" class="logo-light">
                    <img src="/images/logo-sm.png" height="30" class="me-1" alt="logo sm">
                    <img src="/images/logo-light.png" height="24" alt="logo light">
                </a>
            </div>

            <h2 class="fw-bold text-center fs-18">Sign In</h2>
            <p class="text-muted text-center mt-1 mb-4">
                Enter your email address and password to access the admin panel.
            </p>

            <div class="px-4">

                <form method="POST" action="{{ route('login') }}" class="authentication-form">
                    @csrf

                    @foreach ($errors->all() as $error)
                        <p class="text-danger mb-3">{{ $error }}</p>
                    @endforeach

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               placeholder="Enter your email"
                               value="{{ old('email') }}"
                               required autofocus>
                    </div>

                    <div class="mb-3">
                        <a href="{{ route('password.request') }}"
                           class="float-end text-muted text-unline-dashed ms-1">
                            Reset password
                        </a>

                        <label class="form-label">Password</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Enter your password"
                               required>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox"
                                   class="form-check-input"
                                   name="remember"
                                   id="checkbox-signin">

                            <label class="form-check-label" for="checkbox-signin">
                                Remember me
                            </label>
                        </div>
                    </div>

                    <div class="mb-1 text-center d-grid">
                        <button class="btn btn-primary" type="submit">Sign In</button>
                    </div>
                </form>

                <p class="mt-3 fw-semibold no-span">OR sign with</p>

                <div class="text-center">
                    <a href="#" class="btn btn-light shadow-none"><i class='bx bxl-google fs-20'></i></a>
                    <a href="#" class="btn btn-light shadow-none"><i class='bx bxl-facebook fs-20'></i></a>
                    <a href="#" class="btn btn-light shadow-none"><i class='bx bxl-github fs-20'></i></a>
                </div>
            </div>
        </div>
    </div>

    <p class="mb-0 text-center">
        New here?
        <a href="{{ route('register') }}" class="text-reset fw-bold ms-1">Sign Up</a>
    </p>

</div>

@endsection
