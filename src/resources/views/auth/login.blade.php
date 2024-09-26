@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header">Login</div>

                    <div class="card-body">
                        <form method="POST" action="/login">
                            @csrf

                            <div class="row justify-content-center my-3">
                                <div class="col-10">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        placeholder="Email" value="{{ old('email') }}" required autocomplete="email"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row justify-content-center my-3">
                                <div class="col-10">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="Password" required autocomplete="current-password">
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="d-grid col-10 mx-auto">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="mt-3 text-center" href="{{ route('password.request') }}">
                                            Forgot your password?
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
