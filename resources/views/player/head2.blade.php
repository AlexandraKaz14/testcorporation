<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}"/>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">

    <meta property="og:title" content="@yield('og_title')">
    <meta property="og:description" content="@yield('og_description')">
    <meta property="og:image" content="@yield('og_image')">
    <meta property="og:image:width" content="800">
    <meta property="og:image:height" content="800">
    <meta property="og:url" content="@yield('og_url')">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Корпорация теста">
    <meta property="og:locale" content="ru_RU">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://kit.fontawesome.com/030f77f060.js" crossorigin="anonymous"></script>


    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <style>
{{--                        {!! $theme->css_style !!}--}}

       .swal-button {
            padding: 7px 19px;
            border-radius: 8px;
            background: #537a5a !important;
            color: #ffffff !important;
            font-size: 16px;
            border: 1px solid #39543e;
        }

        .swal-text {
            text-align: center;
        }

        .btn-back-catalog {
            padding-top: 20px;
            padding-right: 20px;
            color: rgba(0, 0, 0, 0.76);
        }

        .btn-result-back-catalog {
            color: rgba(0, 0, 0, 0.76);
        }


        body {
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .main-content {
            padding-top: 50px;
            padding-bottom: 50px;
            background-color: #f8fff8;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 80 40' width='80' height='40'%3E%3Cpath fill='%2398c297' fill-opacity='0.2' d='M0 40a19.96 19.96 0 0 1 5.9-14.11 20.17 20.17 0 0 1 19.44-5.2A20 20 0 0 1 20.2 40H0zM65.32.75A20.02 20.02 0 0 1 40.8 25.26 20.02 20.02 0 0 1 65.32.76zM.07 0h20.1l-.08.07A20.02 20.02 0 0 1 .75 5.25 20.08 20.08 0 0 1 .07 0zm1.94 40h2.53l4.26-4.24v-9.78A17.96 17.96 0 0 0 2 40zm5.38 0h9.8a17.98 17.98 0 0 0 6.67-16.42L7.4 40zm3.43-15.42v9.17l11.62-11.59c-3.97-.5-8.08.3-11.62 2.42zm32.86-.78A18 18 0 0 0 63.85 3.63L43.68 23.8zm7.2-19.17v9.15L62.43 2.22c-3.96-.5-8.05.3-11.57 2.4zm-3.49 2.72c-4.1 4.1-5.81 9.69-5.13 15.03l6.61-6.6V6.02c-.51.41-1 .85-1.48 1.33zM17.18 0H7.42L3.64 3.78A18 18 0 0 0 17.18 0zM2.08 0c-.01.8.04 1.58.14 2.37L4.59 0H2.07z'%3E%3C/path%3E%3C/svg%3E");
        }

        .test-container {
            max-width: 1000px;
            margin: 100px auto;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            background-color: #ffffff;

        }


        .test-container:hover {
            transform: translateY(-10px);
        }

        .test-body {
            padding: 24px;
        }

        .btn-start {
            font-size: 20px;
            border: none;
            padding: 10px 30px;
            text-align: center;
            transition: 0.5s;
            background-size: 200% auto;
            color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            background-color: #537a5a;


        }

        .btn-start:hover {
            background-position: right center;
            color: white;
            background-color: rgb(52, 96, 52);

        }

        .btn-repeat {
            font-size: 16px;
            border: none;
            padding: 10px 10px;
            text-align: center;
            transition: 0.5s;
            background-size: 200% auto;
            color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            background-color: #537a5a;

        }

        .btn-repeat:hover {
            background-position: right center;
            background-color: #346034;
            color: white;

        }

        .categories {
            margin-top: 10px;
        }

        .test-categories-container {
            margin-top: 5px;
            margin-bottom: 15px;

        }

        .btn-test-categories {
            margin-left: 2px;
            margin-right: 2px;
            border-color: rgba(0, 0, 0, 0.71);
        }

        .btn-test-categories:hover {
            border-color: rgba(0, 0, 0, 0.71);
            background-color: rgb(52, 96, 52);
            color: white;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.17);
        }

        .test-tags {
            margin-left: 1px;
            margin-right: 1px;
            background-color: rgb(83, 122, 90);
        }

        .test-tags:hover {
            color: white;
            background-color: rgb(52, 96, 52);
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.17);
        }


        .test-tags-container {
            margin: 40px 0 0;
        }

        .test-title {
            margin: 10px 0;
            color: #333;
            font-family: Calibri, sans-serif;
        }

        .test-description {
            font-size: 18px;
            color: rgba(0, 0, 0, 0.76);
            margin-top: 15px;
            font-family: Calibri, sans-serif;
            text-align: justify; /* Выравнивание текста по ширине */
            word-break: break-word; /* Перенос слов при необходимости */
            hyphens: auto; /* Автоматический перенос слов для улучшения выравнивания */
        }

        .test-info {
            color: #000000;
        }

        .count-questions {
            color: rgba(0, 0, 0, 0.76);
        }

        .image-container {
            width: 500px;
            height: 400px;
            overflow: hidden; /* Обрезаем изображение */
            margin: 20px auto 0; /* Центрирование контейнера изображения */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .test-image {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Пропорционально масштабируем изображение */
            border-radius: 10px;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.17);
        }

        .question-container {
            max-width: 1000px;
            margin: 100px auto;
            /*background-color: rgba(191, 192, 232, 0.71);*/
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px; /* дополнительно */
            background-color: #ffffff;

        }

        .question-body {
            padding: 10px 10px 10px 10px;
        }

        .image-container-question {
            max-width: 500px;
            width: 100%;
            height: auto;
            margin: 20px auto 0; /* Центрирование контейнера изображения */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .question-image {
            width: 100%;
            height: auto;
            object-fit: contain;/* Масштабируем изображение без обрезки */
            border-radius: 10px;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.17);
        }

        @media (max-width: 768px) {
            .image-container-question {
                max-width: 100%; /* Разрешаем контейнеру растягиваться */
                height: auto; /* Подстраиваем высоту */
            }

            .question-image {
                width: 100%;
                height: auto;
            }
        }

        .question-text {
            font-size: 18px;
            color: rgba(0, 0, 0, 0.76);
            margin-bottom: 20px;
            margin-top: 20px;
            font-family: Calibri, sans-serif;
            text-align: justify;
            hyphens: auto;
            word-break: break-word;
        }

        .btn-next {
            margin-top: 20px;
            width: 100%;
            font-size: 20px;
            border: none;
            padding: 10px 30px;
            text-align: center;
            transition: 0.5s;
            background-size: 200% auto;
            color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            background-color: #537a5a;
        }

        .btn-next:hover {
            background-position: right center;
            background-color: rgb(52, 96, 52);
        }

        .radio-section {
            display: flex;
            align-items: center;
            justify-content: left;
        }

        .radio-item [type="radio"] {
            display: none;
        }

        .radio-item + .radio-item {
            margin-top: 10px;
        }

        /* Радиокнопка */
        .radio-item label {
            white-space: normal;
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-width: 100%;
            display: block;
            padding: 10px 10px 10px 50px;
            background: rgba(190, 190, 190, 0.34);
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-family: Calibri, sans-serif;
            position: relative;
            transition: all 0.3s ease-in-out;
        }

        /* Создание круга радио-кнопки */
        .radio-item label::after {
            content: "";
            position: absolute;
            height: 20px;
            width: 20px;
            border: 2px solid #537a5a;
            border-radius: 50%;
            left: 19px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
        }


        /* Внутренний круг для выбранного состояния */
        .radio-item label::before {
            content: "";
            position: absolute;
            background: rgb(83, 122, 90);
            height: 10px;
            width: 10px;
            border-radius: 50%;
            left: 24px;
            top: 50%;
            transform: translateY(-50%) scale(0);
            opacity: 0;
            transition: all 0.3s ease-in-out;
        }

        /* Анимация при выборе */
        .radio-item [type="radio"]:checked + label {
            box-shadow: 0px 0px 10px rgb(71, 107, 71);
        }

        /* Показываем внутренний круг */
        .radio-item [type="radio"]:checked + label::before {
            transform: translateY(-50%) scale(1);
            opacity: 1;
        }

        .progress-container {
            width: 100%;
            background-color: #e0e0e0;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 15px;
        }

        .progress-bar {
            height: 10px;
            background-color: #346034;
            width: 0;
            transition: width 0.4s ease;
        }

        .progress-text {
            font-size: 20px;
            text-align: left;
            color: rgb(52, 96, 52);
            font-family: Comic Sans MS, sans-serif;

        }

        .radio-input {
            display: none;
        }

        /* Карточка выбора */
        .radio-label {
            cursor: pointer;
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 250px;
            height: 300px;
            transition: all 0.3s ease-in-out;
            position: relative;
            background: rgba(190, 190, 190, 0.34);
        }

        /* Изображение внутри карточки */
        .radio-image {
            width: 100%;
            height: auto;
            max-width: 200px;
            transition: transform 0.3s ease;
        }

        /* Анимация при выборе */
        .radio-input:checked + .radio-label {
            box-shadow: 0 0 10px 10px rgb(71, 107, 71) !important;
            /*box-shadow: 0 0 10px rgb(103, 99, 99);*/
            transform: scale(1.05); /* Немного увеличиваем при выборе */
        }

        .result-share p {
            font-size: 1.1em;
            color: #333;
        }

        img {
            max-width: 100%;
            display: block;
            vertical-align: middle;
        }

        .image-container-answer {
            width: 100%;
            height: 300px;
            overflow: hidden;
            margin: 5px auto 0;
            display: flex;
            border-radius: 5px;
            justify-content: center;
            align-items: center;
        }

        .answer-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 5px;
            box-shadow: 0 2px 2px rgb(71, 107, 71);
        }

        .answer-text {
            font-size: 16px;
            margin-top: 10px;
            font-family: Calibri, sans-serif;
            hyphens: auto;
            word-break: break-word;
        }

        label.radio-card {
            cursor: pointer;
            display: block;
            height: 100%;
        }

        label.radio-card .card-content-wrapper {
            background: rgba(190, 190, 190, 0.34);
            border-radius: 10px;
            width: 100%;
            height: 100%;
            padding: 15px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 4px 0 rgba(190, 190, 190, 0.34);
            transition: 200ms linear;
        }

        label.radio-card .check-icon {
            width: 20px;
            height: 20px;
            display: inline-block;
            border: 2px solid rgb(83, 122, 90);
            border-radius: 50%;
            transition: 200ms linear;
            position: relative;
        }

        label.radio-card .check-icon::after {
            content: "";
            width: 10px;
            height: 10px;
            background: rgb(83, 122, 90);
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            transition: 200ms linear;
        }

        label.radio-card .check-icon:before {
            content: "";
            position: absolute;
            inset: 0;
            background-repeat: no-repeat;
            background-size: 12px;
            background-position: center center;
            transform: scale(1.6);
            transition: 200ms linear;
            opacity: 0;
        }

        label.radio-card input[type=radio] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        label.radio-card input[type=radio]:checked + .card-content-wrapper .check-icon {
            border-color: rgb(83, 122, 90);
        }

        label.radio-card input[type=radio]:checked + .card-content-wrapper .check-icon::after {
            transform: translate(-50%, -50%) scale(1);
        }

        label.radio-card input[type=radio]:checked + .card-content-wrapper {
            box-shadow: 0px 0px 10px rgb(71, 107, 71);
        }

        label.radio-card input[type=radio]:checked + .card-content-wrapper .check-icon:before {
            transform: translateY(-50%) scale(1.2);
            opacity: 1;
        }

        /*/стили результатов*!*!*/

        .main-result {
            padding-top: 50px;
            padding-bottom: 50px;
            background-color: rgb(255, 255, 255);

            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 80 40' width='80' height='40'%3E%3Cpath fill='%2398c297' fill-opacity='0.2' d='M0 40a19.96 19.96 0 0 1 5.9-14.11 20.17 20.17 0 0 1 19.44-5.2A20 20 0 0 1 20.2 40H0zM65.32.75A20.02 20.02 0 0 1 40.8 25.26 20.02 20.02 0 0 1 65.32.76zM.07 0h20.1l-.08.07A20.02 20.02 0 0 1 .75 5.25 20.08 20.08 0 0 1 .07 0zm1.94 40h2.53l4.26-4.24v-9.78A17.96 17.96 0 0 0 2 40zm5.38 0h9.8a17.98 17.98 0 0 0 6.67-16.42L7.4 40zm3.43-15.42v9.17l11.62-11.59c-3.97-.5-8.08.3-11.62 2.42zm32.86-.78A18 18 0 0 0 63.85 3.63L43.68 23.8zm7.2-19.17v9.15L62.43 2.22c-3.96-.5-8.05.3-11.57 2.4zm-3.49 2.72c-4.1 4.1-5.81 9.69-5.13 15.03l6.61-6.6V6.02c-.51.41-1 .85-1.48 1.33zM17.18 0H7.42L3.64 3.78A18 18 0 0 0 17.18 0zM2.08 0c-.01.8.04 1.58.14 2.37L4.59 0H2.07z'%3E%3C/path%3E%3C/svg%3E");
        }

        .result-container {
            max-width: 1000px;
            margin: 100px auto;
            background-color: rgb(255, 255, 255);
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px; /* дополнительно */
        }

        .result-body {
            /*padding: 20px 40px 40px 40px;*/
            padding: 4px;

        }

        .image-container-result {
            width: 500px;
            height: 400px;
            overflow: hidden; /* Обрезаем изображение */
            margin: 10px auto 0; /* Центрирование контейнера изображения */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .result-image {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Пропорционально масштабируем изображение */
            border-radius: 10px;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.17);
        }

        .result-text {
            font-size: 18px;
            margin: 30px 0;
            padding-left: 12px;
            padding-right: 12px;
            font-family: Calibri, sans-serif;
            text-align: justify;
            hyphens: auto;
            word-break: break-word;
        }

        .test-title-result {
            font-size: 24px;
            margin: 10px 0 20px 0;
            color: #333;
            font-family: Calibri, sans-serif;
        }

        .result-share p {
            font-size: 1.1em;
            color: #333;
        }

        .container {
            position: relative; /* Это нужно для позиционирования прелоадера */
            width: 100%;
            height: 200px;
            background-color: #8d8a8a;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .content {
            font-size: 24px;
            color: #333;
        }

        /* Центрируем по экрану */
        .preloader {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80px;
            width: 80px;
            z-index: 9999;
        }

        /* Анимированные кружки */
        .preloader div {
            position: absolute;
            width: 18px;
            height: 18px;
            background-color: rgb(52, 96, 52);
            border-radius: 50%;
            animation: bounce 1.5s infinite ease-in-out;
        }

        .preloader div:nth-child(2) {
            animation-delay: -0.75s;
        }

        /* Bounce-анимация */
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-40px);
            }
        }

        /* Адаптация под мобильные устройства */
        @media (max-width: 480px) {
            .preloader {
                height: 60px;
                width: 60px;
            }

            .preloader div {
                width: 12px;
                height: 12px;
            }

            @keyframes bounce {
                0%, 100% {
                    transform: translateY(0);
                }
                50% {
                    transform: translateY(-25px);
                }
            }
        }


        .share-button {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .a2a_svg, .a2a_count {
            border-radius: 10px !important;
        }

    </style>


</head>



