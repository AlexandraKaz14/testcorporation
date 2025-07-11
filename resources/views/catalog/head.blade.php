<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(isset($metaNoIndex) && $metaNoIndex)
        <meta name="robots" content="noindex, nofollow">
    @endif
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />

    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">

    <meta property="og:title" content="@yield('og_title')">
    <meta property="og:description" content="@yield('og_description')">
    <meta property="og:image" content="@yield('og_image')">
    <meta property="og:image:width" content="800">
    <meta property="og:image:height" content="800">
    <meta property="og:url" content="@yield('og_url')">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Корпорация тестов">
    <meta property="og:locale" content="ru_RU">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/030f77f060.js" crossorigin="anonymous"></script>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


    <!-- Подключение стилей Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Подключение скрипта Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <style>

        html, body {
            height: 100%; /* Убедитесь, что HTML и body занимают всю высоту */
            margin: 0; /* Уберите отступы */
            display: flex;
            flex-direction: column; /* Установите направление колонок */
        }

        body{
            margin-top: 80px;
            background-color: rgba(192, 182, 250, 0.27);
            flex: 1; /* Дайте body гибкость */
        }

        .title-catalog {
            font-size: 36px;
            font-weight: bold;
            font-family: Calibri, sans-serif;
        }

        .description-catalog{
            font-size: 18px;
            color: #3d446a;
            margin-bottom: 40px;
            font-family: Calibri, sans-serif;
        }

        .user-link {
            color: #ddd; /* Цвет текста ссылок */
            text-decoration: none; /* Убираем подчеркивание */
        }

        .menu-panel {
            padding-left: 16px;
            padding-top: 8px;
            padding-bottom: 8px;
        }

        .user-link:hover {
            color: #fff;
        }

        .footer-catalog{
            background-color: rgb(220, 224, 234);
            box-shadow: 0 0 8px 6px rgba(0, 0, 0, 0.1);
            margin-top: auto; /* Автоматический отступ сверху для прижатия вниз */
        }

        .custom-pagination-class .page-link {
            color: rgba(0, 0, 0, 0.76);
        }

        .info-selected-author-tag{
            background-color: #3d446a;
            font-size: 16px;
            border-radius: 6px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: #fff;
        }

        .info-selected{
            margin-bottom: 40px;
            margin-top: 40px;
        }

        .custom-pagination-class .page-item.active .page-link  {
            background-color: #3d446a;
            border-color: #3d446a;
            color: rgb(255, 255, 255);
        }

        .container-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 70px;
            background-color: rgb(61, 68, 106);
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 1030;
        }

        .logo-container {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        /* Стили для боковой панели */
        #sidebar {
            height: 100vh;
            width: 300px;
            background-color: rgb(61, 68, 106);
            color: #fff;
            position: fixed;
            top: 0;
            left: -300px; /* Скрытое состояние */
            z-index: 1050;
            transition: all 0.3s;
        }

        #sidebar.active {
            left: 0; /* Открытое состояние */
        }

        #sidebar .nav-link {
            color: #ddd;
        }

        #sidebar .nav-link:hover {
            color: #fff;

        }

        /* Затемнение */
        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: none;
        }

        #overlay.active {
            display: block;
        }

        .btn-look-test{
            background-color: rgb(61, 68, 106);
            color: #ffffff;
            transition: all 0.4s;
        }

        .btn-look-test:hover {
            background-color: rgba(82, 83, 203, 0.71); /* Цвет при наведении */
            color: #ffffff;
        }

        .btn-categories {
            margin-top: 20px;
        }

        /*.btn-category {*/
        /*    background-color: #0f97e7;*/
        /*    color: #ffffff;*/
        /*}*/

        /*.btn-category:hover {*/
        /*    background-color: rgb(44, 40, 167);*/
        /*    color: #ffffff;*/
        /*}*/

        .btn-tag {
            background-color: rgb(61, 68, 106);
            color: #ffffff;
            border-radius: 15px;
        }

        .btn-tag:hover {
            background-color: rgba(82, 83, 203, 0.71); /* Цвет при наведении */
            color: #ffffff;
        }

        .sidebar-btn {
            left: 15px; /* Прижатие к левому краю */
            z-index: 1060; /* Поверх всего остального */
            background-color: rgb(61, 68, 106); /* Цвет кнопки */
            color: white; /* Цвет текста */
            padding: 10px 15px; /* Отступы внутри кнопки */
            border-radius: 4px; /* Закругленные углы */
            cursor: pointer; /* Указатель мыши при наведении */
            border: none;
        }

        /*.sidebar-btn:hover {*/
        /*    border: solid white;*/
        /*    border-radius: 8px;*/
        /*}*/

        .dropdown {
            position: relative;
            display: inline-block;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            /*width: 300px;*/
            width: 100%;
        }

        .dropdown-header {
            padding: 15px;
            font-size: 18px;
            color: #2c5b98;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dropdown-header:hover {
            background-color: #f0f4fa;
            border-radius: 8px;

        }

        .dropdown-header::after {
            content: '▲';
            font-size: 12px;
            transform: rotate(180deg);
            transition: transform 0.3s ease;
        }

        .dropdown.open .dropdown-header::after {
            transform: rotate(0);
        }

        .dropdown-list {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: #fff;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            z-index: 10;
        }

        .dropdown.open .dropdown-list {
            display: block;
        }

        .dropdown-item {
            padding: 12px 15px;
            font-size: 16px;
            color: #2c5b98;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background-color: #f0f4fa;
        }

        .dropdown-item.checked::after {
            content: '✔';
            float: right;
            font-size: 14px;
            color: #ccc;
        }

        .card-author {
            background-color: rgba(255, 255, 255, 0.74);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
            margin-top: 15px;
        }

        .card-author:hover {
            background-color: rgb(240, 244, 250);
        }

        .count-test {
            font-size: 14px;
            color: #646363;
        }

        .title-author {
            font-size: 36px;
            font-weight: bold;
            font-family: Calibri, sans-serif;
            margin-top: 16px;
            /*margin-bottom: 8px;*/
        }

        .description-author{
            font-size: 18px;
            color: #3d446a;
            font-family: Calibri, sans-serif;
        }

        .title-tags {
            font-size: 36px;
            font-weight: bold;
            font-family: Calibri, sans-serif;
            margin-top: 16px;
        }
        .description-tags{
            font-size: 18px;
            color: #3d446a;
            font-family: Calibri, sans-serif;

        }
        .title-groups {
            font-size: 36px;
            font-weight: bold;
            font-family: Calibri, sans-serif;
            margin-top: 16px;
        }
        .description-groups{
            font-size: 18px;
            color: #3d446a;
            font-family: Calibri, sans-serif;
        }
        .title-group-test {
            font-size: 36px;
            font-weight: bold;
            font-family: Calibri, sans-serif;
            margin-top: 16px;
        }
        .title-create-test {
            font-size: 36px;
            font-weight: bold;
            font-family: Calibri, sans-serif;
            margin-top: 16px;
            /*margin-bottom: 8px;*/
        }


        .test-card {
            width: 100%;
            margin: auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%; /* Обеспечивает одинаковую высоту карточек */
        }


        .test-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }


        .test-card-body {
            padding: 16px;
            text-align: center;
            flex-grow: 1; /* Расширяет тело карточки, чтобы занять оставшееся пространство */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .btn-start {
            background-color: #3d446a;
            color: white;
            margin-top: auto; /* Выталкивает кнопку вниз */
            align-self: center; /* Центрирует кнопку */
        }


        .btn-start:hover {
            background-color: #3d446a;
            color: white;
            box-shadow: 0 6px 6px rgba(61, 68, 106, 0.47);
        }


        .test-card-body .badge {
            margin-bottom: 8px;
        }


        .test-card-title {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 8px;
            color: #3d446a;
            /*flex-grow: 1; !* Заголовок занимает оставшееся пространство, если нужно *!*/
        }

        .test-card-duration {
            color: #888;
            font-size: 0.9rem;
            margin-top: auto; /* Отодвигает элемент вниз */
        }

        .authors-card{
            margin-top: 20px;
        }

        .container-tags{
            display: flex;
            flex-direction: column;
            /*height: 100%;*/
        }

        .count-taking-test{
            margin-top: 16px;
            color: #888;
            font-size: 0.9rem;
        }



        .collection-card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            background-color: white;
            width: 100%;
            margin: auto;
            display: flex;
            flex-direction: column;
            height: 100%; /* Задаем карточке высоту 100% */
        }

        .collection-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .collection-card-body {
            width: 100%;
            flex-grow: 1; /* Заполняет оставшееся пространство */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }


        .group-card-title {
            font-size: 1.1rem;
            font-weight: bold;
            margin: 8px 5px 0px 5px;
            color: #3d446a;
            flex-shrink: 0; /* Предотвращает сжатие заголовка */
        }


        .collection-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 26px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .collection-card img {
                height: 250px;
            }
        }

        .count-test-group {
            color: #888;
            font-size: 0.9rem;
            flex-shrink: 0; /* Предотвращает сжатие счетчика */
        }


        .description-group{
            background-color: rgba(219, 222, 255, 0.42);
            font-size: 16px;
        }

        .card-group-tests {
            border: none; /* Убрать рамку для более минималистичного вида */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            transition: transform 0.3s, box-shadow 0.3s;

        }

        .card-image-group {
            width: 100%;
            /* Занимает всю ширину блока */
            height: 100%;        /* Автоматически подстраивается по высоте */
            object-fit: cover;   /* Сохраняет пропорции изображения и обрезает лишнее */
        }

        @media (min-width: 992px) {
            .card-group-tests {
                max-width: 100%; /* На больших экранах карточки на всю ширину */
            }
            }

        .text-group{
            text-align: justify;
        }

        .card-title-group {
            color: #3d446a;
            word-break: break-all;
        }

        .card-group-tests:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 26px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        /**
     * Стили страницы создание своего теста
     */

        .btn-registration {
            background-color: rgb(61, 68, 106);
            color: #ffffff;
            border-radius: 10px;
            font-family: Calibri, sans-serif;
        }

        .btn-registration:hover {
            background-color: rgba(82, 83, 203, 0.71);
            color: #ffffff;
        }

        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100px;  /* Размер кнопки */
            height: 100px;
            font-size: 60px; /* Размер иконки */
            text-decoration: none;
            transition: all 0.3s ease;
        }




        /**
        * Стили инструкции создания тестов
        */

        .container-instructions {
            max-width: 1200px;
            margin: 10px auto;
            padding: 0 10px;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .feature {
            background-color: rgba(69, 114, 96, 0.12);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
            transition: transform 0.3s ease;
        }

        .feature:hover {
            transform: scale(1.05);
        }

        .text-justify{
            text-align: justify;
            word-break: break-word;
            hyphens: auto;
        }

        .feature h4 {
            font-size: 1.5em;
            margin-bottom: 10px;
            color: #000000;
        }

        .feature p {
            font-size: 1em;
            color: #555555;
        }

        @media (max-width: 768px) {
            header h1 {
                font-size: 2em;
            }

            .cta a {
                padding: 12px 20px;
                font-size: 1em;
            }
        }


        .form-control-borderless {
            border: none;
            padding-left: 50px;
        }

        .form-control:focus {
            box-shadow: 0 0 10px 10px rgba(192, 182, 250, 0.78) !important;
            opacity: 0.8;
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            font-size: 1.2rem;
            color: #999;
            cursor: pointer;
            transition: color 0.4s ease, left 0.3s ease; /* Плавный переход цвета и смещения */
        }

        /* При фокусе на инпуте иконка становится цветной и смещается вправо */
        .form-control:focus ~ .search-icon {
            color: rgb(112, 158, 130);
            left: 15px; /* Смещение немного вправо */
        }

        .search-no-return {
            font-size: 24px;
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .VkIdWebSdk__button_reset {
            border: none;
            margin: 0;
            padding: 0;
            width: auto;
            overflow: visible;
            background: transparent;
            color: inherit;
            font: inherit;
            line-height: normal;
            -webkit-font-smoothing: inherit;
            -moz-osx-font-smoothing: inherit;
            -webkit-appearance: none;
        }

        .VkIdWebSdk__button {
            background: #0077ff;
            cursor: pointer;
            transition: all .1s ease-out;
        }

        .VkIdWebSdk__button:hover{
            opacity: 0.8;
        }

        .VkIdWebSdk__button:active {
            opacity: .7;
            transform: scale(.97);
        }

        .VkIdWebSdk__button {
            border-radius: 8px;
            width: 100%;
            min-height: 44px;
        }

        .VkIdWebSdk__button_container {
            display: flex;
            align-items: center;
            padding: 8px 10px;
        }

        .VkIdWebSdk__button_icon + .VkIdWebSdk__button_text {
            margin-left: -28px;
        }

        .VkIdWebSdk__button_text {
            display: flex;
            font-family: -apple-system, system-ui, "Helvetica Neue", Roboto, sans-serif;
            flex: 1;
            justify-content: center;
            color: #ffffff;
        }


        .btn-form-mail {
            background-color: rgb(61, 68, 106);
            color: #ffffff;
            border-radius: 10px;
            font-family: Calibri, sans-serif;
        }

        .btn-form-mail:hover {
            background-color: rgba(82, 83, 203, 0.71);
            color: #ffffff;
        }

        .form-control-mail-submit {
            border: none !important;
            box-shadow: none !important;
        }

        .container-feedback {
            max-width: 1200px;
            margin: 10px auto;
            padding-bottom: 30px;
        }

        .welcome-text{
            text-align: justify;
            font-family: Calibri, sans-serif;
            font-size: 18px;
            hyphens: auto;
            word-break: break-word;
        }
        .project-description{
            text-align: justify;
            font-family: Calibri, sans-serif;
            font-size: 18px;
            hyphens: auto;
            word-break: break-word;
        }

    </style>

</head>
