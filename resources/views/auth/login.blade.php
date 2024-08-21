@extends('layouts.app')
@section('content')
<div class="card-login" style="padding-top: 5%; padding-bottom: 5%;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row" >
                        <img class="col-lg-6 d-lg-block" src="/images/resources/login_logo.jpeg">
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Iniciar sesión</h1>
                                </div>
                                <form class="user" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                            <div class="input-group-append">
                                                <button id="show_password" class="btn btn-primary" style="display: inline-block; background: #0d6efd; color: white; " type="button" onclick="fShowPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                                            </div>
                                        </div>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block" style="display: inline-block; background: #0d6efd; color: white; border: 2px solid #ffffff;border-radius: 10px; font-size: large"> Ingresar </button>
                                    </div>
                                </form>
                                <hr>
                                <p id="texto_motivacional" style="text-align: center; font-size: 0.8rem"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-login{
        width: 100%;
        height: 80%;
    }
</style>
@endsection

@push('scripts')
    <script src="{{ asset('js/custom_scripts/show_pass.js') }}"></script>
    <script src="{{ asset('js/custom_scripts/phrases.js') }}"></script>
@endpush
