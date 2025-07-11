<div id="overlay"></div>

<header>
    <div class="container-header d-flex align-items-center justify-content-between">
        <button class="btn  sidebar-btn ms-2" id="sidebarToggle">
            <i class="fa-solid fa-bars fa-2xl" style="color: #ffffff;"></i>
        </button>

        <div class="logo-container">
          <a href="{{ route('catalog') }}">  <img src="/images/logo.webp" class="d-block img-fluid rounded-circle" alt="logo" width="50" height="50" loading="lazy"></a>
        </div>

        <div class="text-end ms-auto">

            @if($currentUser)
                <a href="{{ route('profile') }}" class="me-4"  role="button" style="vertical-align: inherit;">
                    <i class="fa-regular fa-circle-user fa-2xl" style="color: #ffffff;"></i>
                </a>
            @else
                <a href="{{ route('login') }}"  class="btn btn-outline-light me-4" role="button" style="vertical-align: inherit;">
                    Войти
                </a>
            @endif


        </div>
    </div>
</header>

<div id="sidebar">
    <h4 class="text-center py-3">Меню</h4>
    <nav class="nav flex-column px-3">
        <a href="{{route('catalog')}}" class="nav-link"><i class="fa-solid fa-list fa-lg" style="color: #ffffff;"></i> Каталог</a>
        <a href="{{route('catalog.tags')}}" class="nav-link"><i class="fa-solid fa-hashtag fa-lg" style="color: #ffffff;"></i> Все теги</a>
        <a href="{{route('catalog.groups')}}" class="nav-link"><i class="fa-solid fa-ghost fa-lg" style="color: #ffffff;"></i> Тематические
            подборки</a>
        <a href="{{route('catalog.authors')}}" class="nav-link"><i class="fa-solid fa-user fa-lg" style="color: #ffffff;"></i> Авторы тестов</a>
        <a href="{{route('catalog.create')}}" class="nav-link"><i class="fa-solid fa-pen-to-square fa-lg" style="color: #ffffff;"></i> Создать свой тест</a>
        <div  class="menu-panel">
            <a href="{{ route('login') }}" class="user-link"><i class="fa-solid fa-circle-user fa-lg" style="color: #ffffff;"></i> Войти</a> |
            <a href="{{ route('register') }}" class="user-link">Регистрация</a>
        </div>
    </nav>

</div>


<script>
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    // Открыть/закрыть боковую панель
    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    });

    // Закрыть панель при клике на overlay
    overlay.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });
</script>
