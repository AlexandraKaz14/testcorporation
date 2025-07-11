@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@section('title', 'Регистрация нового пользователя')
@section('description', 'Зарегистрируйтесь в личном кабинете и создавайте тесты прямо сейчас')
@section('keywords', 'создание теста, свой тест, бесплатное создание тестов, создатели тестов, лучшие тесты, интересные тесты, платформа тестов, пройти тест, найти тест, бесплатно создать тест, создать тест просто и быстро')

@section('og_title', 'Регистрация нового пользователя')
@section('og_description', 'Зарегистрируйтесь в личном кабинете и создавайте тесты прямо сейчас')
@section('og_image',asset('images/logo.webp'))
@section('og_url',url()->current())

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
@endif

@section('auth_header', __('adminlte::adminlte.register_message'))

@section('adminlte_css_pre')

    <style>

        /*---------------------------------------------*/
        input {
            outline: none;
            border: none;
        }

        textarea {
            outline: none;
            border: none;
        }

        textarea:focus, input:focus {
            border-color: transparent !important;
        }

        input:focus::-webkit-input-placeholder {
            color: transparent;
        }

        input:focus:-moz-placeholder {
            color: transparent;
        }

        input:focus::-moz-placeholder {
            color: transparent;
        }

        input:focus:-ms-input-placeholder {
            color: transparent;
        }

        textarea:focus::-webkit-input-placeholder {
            color: transparent;
        }

        textarea:focus:-moz-placeholder {
            color: transparent;
        }

        textarea:focus::-moz-placeholder {
            color: transparent;
        }

        textarea:focus:-ms-input-placeholder {
            color: transparent;
        }


        textarea::-webkit-input-placeholder {
            color: #999999;
        }

        textarea:-moz-placeholder {
            color: #999999;
        }

        textarea::-moz-placeholder {
            color: #999999;
        }

        textarea:-ms-input-placeholder {
            color: #999999;
        }

        /*---------------------------------------------*/
        button {
            outline: none !important;
            border: none;
            background: transparent;
        }

        button:hover {
            cursor: pointer;
        }

        iframe {
            border: none !important;
        }


        .txt2 {
            font-family: Calibri, sans-serif;
            font-size: 15px;
            line-height: 1.5;
            color: #666666;
        }

        .limiter {
            width: 100%;
            margin: 0 auto;
        }

        .container-login100 {
            width: 100%;
            min-height: 100vh;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 15px;
        }


        .wrap-login100 {
            width: 960px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 50px 130px 50px 95px;
            align-items: center; /* Центрирование содержимого картинки, если нужно */

        }

        /*------------------------------------------------------------------
        [  ]*/
        .login100-pic {
            width: 316px;
        }

        .login100-pic img {
            max-width: 100%;
            height: auto;
            aspect-ratio: 1 / 1;
        }


        /*------------------------------------------------------------------
        [  ]*/
        .login100-form {
            width: 290px;
        }

        .login100-form-title {
            font-family: Calibri, sans-serif;
            font-size: 24px;
            color: #333333;
            line-height: 1.2;
            text-align: center;
            width: 100%;
            display: block;
            padding-bottom: 30px;
        }


        /*---------------------------------------------*/
        .wrap-input100 {
            position: relative;
            width: 100%;
            z-index: 1;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .input100 {
            font-family: Calibri, sans-serif;
            font-size: 15px;
            line-height: 1.5;
            color: #666666;
            display: block;
            width: 100%;
            background: #e6e6e6;
            height: 50px;
            border-radius: 10px;
            padding: 0 30px 0 68px;
        }


        /*------------------------------------------------------------------
        [ Focus ]*/
        .focus-input100 {
            display: block;
            position: absolute;
            border-radius: 10px;
            bottom: 0;
            left: 0;
            z-index: -1;
            width: 100%;
            height: 100%;
            color: rgba(192, 182, 250, 0.78);

        }

        .input100:focus + .focus-input100 {
            -webkit-animation: anim-shadow 0.5s ease-in-out forwards;
            animation: anim-shadow 0.5s ease-in-out forwards;
        }

        @keyframes anim-shadow {
            to {
                box-shadow: 0px 0px 10px 10px;
                opacity: 0.8;
            }
        }

        .symbol-input100 {
            font-size: 20px;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            align-items: center;
            position: absolute;
            border-radius: 25px;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding-left: 35px;
            pointer-events: none;
            color: #666666;
            transition: all 0.4s;
        }

        .input100:focus + .focus-input100 + .symbol-input100 {
            color: rgb(112, 158, 130);
            padding-left: 28px;
        }

        /*------------------------------------------------------------------
        [ Button ]*/
        .container-login100-form-btn {
            width: 100%;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding-top: 20px;
        }

        .login100-form-btn {
            font-family: Calibri, sans-serif;
            font-size: 18px;
            line-height: 1.5;
            color: #fff;
            width: 100%;
            height: 50px;
            border-radius: 10px;
            background: rgb(61, 68, 106);
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 25px;
            transition: all 0.4s;
        }

        .login100-form-btn:hover {
            background: rgba(82, 83, 203, 0.71);
        }


        /*------------------------------------------------------------------
        [ Responsive ]*/


        @media (min-width: 1400px) {
            .wrap-login100 {
                display: flex;
                align-items: center; /* Центрирование по вертикали */
                justify-content: space-between; /* Пространство между картинкой и формой */
                padding: 70px 70px; /* Сократите padding, если нужно */
            }

            .login100-pic {
                width: 35%;
                display: flex;
                align-items: center; /* Центрирование содержимого картинки, если нужно */
                justify-content: center; /* Центрирование содержимого картинки */
            }

            .login100-form {
                width: 50%;
            }
        }

        @media (max-width: 1200px) {
            .wrap-login100 {
                display: flex;
                align-items: center; /* Центрирование по вертикали */
                justify-content: space-between; /* Пространство между картинкой и формой */
                padding: 70px 70px; /* Сократите padding, если нужно */
            }

            .login100-pic {
                width: 35%;
                display: flex;
                align-items: center; /* Центрирование содержимого картинки, если нужно */
                justify-content: center; /* Центрирование содержимого картинки */
            }

            .login100-form {
                width: 50%;
            }
        }


        @media (max-width: 992px) {
            .wrap-login100 {
                display: flex;
                align-items: center; /* Центрирование по вертикали */
                justify-content: space-between; /* Пространство между картинкой и формой */
                padding: 50px 50px; /* Сократите padding, если нужно */
            }

            .login100-pic {
                width: 35%;
                display: flex;
                align-items: center; /* Центрирование содержимого картинки, если нужно */
                justify-content: center; /* Центрирование содержимого картинки */
            }

            .login100-form {
                width: 50%;
            }
        }


        @media (max-width: 768px) {
            .wrap-login100 {
                flex-direction: column;
                align-items: center;
            }

            .login100-pic {
                width: 100%;
                margin-bottom: 20px;
                display: flex;
                justify-content: center;
            }

            .login100-pic img {
                max-width: 100px; /* При необходимости уменьшите размер изображения */
            }

            .login100-form {
                width: 100%; /* Чтобы форма растягивалась на всю ширину экрана */
                padding: 0 20px;
            }
        }

        @media (max-width: 576px) {
            .wrap-login100 {
                padding: 50px 10px 33px 10px;
            }
        }


        /*------------------------------------------------------------------
        [ Alert validate ]*/

        .validate-input {
            color: #c80000;
            font-size: 13px;
            text-align: left;
            padding-bottom: 10px;
        }


        @media (max-width: 992px) {
            .validate-input::before {
                visibility: visible;
                opacity: 1;
            }
        }

        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: none;
            font-weight: bold;
            color: #fff;
            cursor: pointer;
            background-color: #4286f5;
        }

    </style>

@endsection

@section('auth_body')

<div class="limiter" style="background-color: rgba(192,182,250,0.27);">
    <div class="container-login100">

        <div class="wrap-login100">
            <div class="login100-pic">
                <img src="/images/logo.webp" alt="Login Image" width="316" height="316"
                     class="lazyload rounded-circle" loading="lazy">
            </div>
            <div class="login100-form">
                <form action="{{ $register_url }}" method="post" class=" validate-form">
                    @csrf

                    <span class="login100-form-title">
                        {{__('adminlte::adminlte.register_message')}}
                    </span>

                    <div class="wrap-input100">
                        <input class="input100  @error('name') is-invalid @enderror" type="text" name="name"
                               placeholder="{{ __('adminlte::adminlte.full_name') }}"
                               value="{{ old('name') }}" autofocus>

                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
                    </div>

                    @error('name')
                    <span class="validate-input" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror

                    <div class="wrap-input100">
                        <input class="input100  @error('email') is-invalid @enderror" type="email" name="email"
                               placeholder="{{ __('adminlte::adminlte.email') }}"
                               value="{{ old('email') }}">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
                    </div>

                    @error('email')
                    <span class="validate-input" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror

                    <div class="wrap-input100" data-validate="Password is required">
                        <input class="input100  @error('password') is-invalid @enderror" type="password" name="password"
                               placeholder="{{ __('adminlte::adminlte.password') }}">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                    </div>

                    @error('password')
                    <span class=" validate-input" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror

                    <div class="wrap-input100" data-validate="Password is required">
                        <input class="input100  @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation"
                               placeholder="{{ __('adminlte::adminlte.retype_password') }}">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                    </div>

                    @error('password_confirmation')
                    <span class=" validate-input" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                    @if (env('TURNSTILE_ENABLED') && env('TURNSTILE_SITE_KEY'))
                        <div class="wrap-input100 mt-3">
                            <div class="cf-turnstile" data-sitekey="{{ env('TURNSTILE_SITE_KEY') }}"></div>
                        </div>

                        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

                        @error('cf-turnstile-response')
                        <span class="validate-input" role="alert">
            <strong>{{ $message }}</strong>
        </span>
                        @enderror
                    @endif
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            {{ __('adminlte::adminlte.register') }}
                        </button>
                    </div>
                </form>

                <div class="text-center pt-3">
                    <p class="txt2">{{ __('adminlte::adminlte.Already have an account?') }}
                        <a  href="{{ $login_url }}">
                            {{ __('adminlte::adminlte.login_in') }}
                        </a>
                    </p>

                </div>
                <p class="text-center txt2">   {{ __('adminlte::adminlte.or_sign_in_with') }}
                </p>

                @include('partial.button-social')


                <div class="text-center pt-4 ">
                    <a class="txt2" href="{{ route('catalog') }}">
                        {{ __('adminlte::adminlte.Return to catalog') }}
                    </a>

                </div>

            </div>

        </div>

    </div>
</div>
@stop




