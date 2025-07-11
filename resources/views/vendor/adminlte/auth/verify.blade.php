@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('adminlte_css_pre')

    <style>

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

        input::-webkit-input-placeholder {
            color: #999999;
        }

        input:-moz-placeholder {
            color: #999999;
        }

        input::-moz-placeholder {
            color: #999999;
        }

        input:-ms-input-placeholder {
            color: #999999;
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


        /*//////////////////////////////////////////////////////////////////
        [ Utility ]*/
        .txt1 {
            margin-top: 15px;
        }

        .txt2 {
            font-family: Calibri, sans-serif;
            font-size: 15px;
            line-height: 1.5;
            color: #666666;
        }


        /*//////////////////////////////////////////////////////////////////
        [ login ]*/

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
            background-color: rgba(192, 182, 250, 0.27);

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
            box-shadow: 0px 0px 0px 0px;
            color: rgb(61, 68, 106);

        }

        .input100:focus + .focus-input100 {
            -webkit-animation: anim-shadow 0.5s ease-in-out forwards;
            animation: anim-shadow 0.5s ease-in-out forwards;
        }

        @-webkit-keyframes anim-shadow {
            to {
                box-shadow: 0px 0px 70px 25px;
                opacity: 0;
            }
        }

        @keyframes anim-shadow {
            to {
                box-shadow: 0px 0px 70px 25px;
                opacity: 0;
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
            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
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
            font-size: 15px;
            line-height: 1.5;
            color: #fff;
            text-transform: uppercase;

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

            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
            transition: all 0.4s;
        }

        .login100-form-btn:hover {
            background: rgba(82, 83, 203, 0.71);
        }

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

        .verify{
            font-size: 18px;
            color: #3d446a;
            font-family: Calibri, sans-serif;
            text-align: justify; /* Растягиваем текст */
            /*text-align-last: center;*/
        }


        .link_sent{
            background-color: rgb(112, 158, 130);
            color: #ffffff;
            border-radius: 10px;
            font-family: Calibri, sans-serif;
            font-size: 16px;
            display: flex;
            padding: 10px 15px 10px 15px;
            margin-bottom: 20px;
        }


    </style>
@stop
@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )

@php( $login_url = $login_url ? route($login_url) : '' )

{{--@section('auth_header', __('adminlte::adminlte.verify_message'))--}}

@section('auth_body')

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-pic">
                <img src="/images/logo.webp" alt="Login Image" width="316" height="316"
                     class="lazyload rounded-circle" loading="lazy">
            </div>
            <div class="login100-form">
                <span class="login100-form-title">
                            {{ __('adminlte::adminlte.verify_message') }}
                    </span>

                @if(session('resent'))
                    <div class="link_sent" role="alert">
                        {{ __('adminlte::adminlte.verify_email_sent') }}
                    </div>
                @endif

                <div class="verify">
                {{ __('adminlte::adminlte.verify_check_your_email') }}<br><br>
                    &#128233;<strong> {{ __('adminlte::adminlte.verify_if_not_recieved') }}</strong>
                    {{ __('adminlte::adminlte.Check your spam folder or resend') }}
                </div>

                <form class="text-center mt-1" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 m-0 ">
                        {{ __('adminlte::adminlte.verify_request_another') }}.
                    </button>
                </form>

                <form  action="{{ route('logout') }}" method="POST" class="text-center">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 mt-3">
                        Вернуться в каталог
                    </button>
                </form>

            </div>

        </div>

    </div>
</div>

@stop
