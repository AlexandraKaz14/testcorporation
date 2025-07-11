<footer class="py-3 footer-catalog mt-auto">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
        <li class="nav-item"><a href="{{ route('catalog') }}" class="nav-link px-2 text-body-secondary">Каталог</a></li>
        <li class="nav-item"><a href="{{ route('project') }}" class="nav-link px-2 text-body-secondary">О проекте</a></li>
        <li class="nav-item"><a href="{{ route('contacts') }}" class="nav-link px-2 text-body-secondary">Контакты</a></li>
    </ul>
    <p class="text-center text-body-secondary">© {{ date('Y') }} {{__('common.test corporation')}}</p>
</footer>




