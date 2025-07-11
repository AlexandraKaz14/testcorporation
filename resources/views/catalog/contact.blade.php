@extends('layouts.catalog')
@section('title', 'Контакты')
@section('description', 'По вопросам и предложениям напишите нам!')
@section('keywords', 'создание тестов, вопросы по Корпорации тестов, простое создание тестов, создать тест быстро, интересные тесты, платформа тестов, конструктор тестов, обратная связь Корпорации тестов')

@section('og_title', 'Контакты')
@section('og_description', 'По вопросам и предложениям напишите нам!')
@section('og_image',asset('images/logo.webp'))
@section('og_url',url()->current())


@section('content')

    <div class="container col-xxl-8 px-4 py-4">
        <h1 class="display-5 fw-bold text-body-emphasis lh-1  text-center title-create-test">Контакты</h1>

        <div class="col-12 g-5 pt-3">
            <p class="project-description lead">Мы всегда рады вашим предложениям и вопросам! 🤗</p>

            <p class="project-description lead">Если у вас возникли трудности в создании тестов или вы хотите поделиться идеями по улучшению "Корпорации тестов" не стесняйтесь обращаться к нам.</p>
        </div>
        <p class="project-description lead"> Напишите в Telegram или воспользуйтесь формой ниже &#128071;</p>

        <div class="d-grid gap-2 d-md-flex justify-content-md-start ">
            <a class="btn btn-registration btn-lg px-4 gap-3 mt-3"
               href="tg://resolve?domain=Test_Corporation"
               role="button"><i class="fa-brands fa-telegram fa-xl mr-2"></i> написать в Telegram</a>
        </div>
    </div>

    <div class="container container-feedback col-xxl-8 px-4  mb-3">
        <div class="feature col  mb-3">
            <h4 class="text-center">  <i class="fa-solid fa-envelope"></i> Напишите ваш вопрос или предложение
            </h4>
            @if(session('success'))
                <div id="success-message" class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('contacts.feedback.send') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Ваше имя</label>
                    <input type="text" class="form-control form-control-mail-submit" id="name" name="name" placeholder="Иван Иванов" required>
                </div>
                <div class="mb-3">
                    <label  class="form-label">Ваш Email </label>
                    <input type="email" class="form-control form-control-mail-submit" id="email" name="email" placeholder="name@example.com" required>
                </div>
                <div class="mb-3">
                    <label for="validationTextarea" class="form-label">Сообщение</label>
                    <textarea class="form-control form-control-mail-submit" id="message" name="message" rows="3" required></textarea>
                </div>
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
                <button type="submit" class="btn btn-form-mail btn-lg px-4 gap-3 mt-3">Отправить</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.getElementById('success-message').style.display = 'none';
            }, 6000);
        });
    </script>
@endsection
