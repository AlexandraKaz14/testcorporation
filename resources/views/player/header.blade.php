<div id="overlay"></div>

<header>
    <div class="container-header">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="#" class="nav-link px-2 text-white">Корпорация тестов</a></li>
            </ul>
        </div>
    </div>
</header>

<div id="sidebar">
    <h4 class="text-center py-3">Меню</h4>
    <nav class="nav flex-column px-3">
        <a href="{{route('catalog')}}" class="nav-link"><i class="fa-solid fa-list fa-lg" style="color: #ffffff;"></i> Каталог</a>
        <a href="{{route('catalog.tags')}}" class="nav-link"><i class="fa-solid fa-hashtag fa-lg" style="color: #ffffff;"></i> Все теги</a>
        <a href="#" class="nav-link"><i class="fa-solid fa-ghost fa-lg" style="color: #b06f09;"></i> Тематические
            подборки</a>
        <a href="{{route('catalog.authors')}}" class="nav-link"><i class="fa-solid fa-user fa-lg" style="color: #ffffff;"></i> Авторы тестов</a>
        <a href="#" class="nav-link">Создать свой тест</a>
        <a href="#" class="nav-link">О проекте</a>
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


