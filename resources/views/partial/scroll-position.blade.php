<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Получаем сохраненную позицию скролла
        const scrollPosition = sessionStorage.getItem("scrollPosition");
        if (scrollPosition !== null) {
            // Используем requestAnimationFrame для плавности
            requestAnimationFrame(() => {
                window.scrollTo({ top: parseInt(scrollPosition, 10), behavior: "smooth" });
            });
        }
    });

    window.addEventListener("beforeunload", function () {
        // Сохраняем текущую позицию прокрутки перед уходом
        sessionStorage.setItem("scrollPosition", window.scrollY);
    });

    // Обработчик кликов для кнопок и ссылок
    document.addEventListener("click", function (event) {
        if (event.target.tagName === "A" || event.target.tagName === "BUTTON") {
            sessionStorage.setItem("scrollPosition", window.scrollY);
        }
    });

    // Обработчик для кнопки "Закрыть" или "Назад"
    document.querySelectorAll('.btn-back').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault(); // Предотвращаем мгновенный переход
            const url = this.getAttribute('href'); // Получаем ссылку

            // Плавно скроллим вверх
            window.scrollTo({ top: 0, behavior: "smooth" });

            // Ждем 300 мс, затем переходим по ссылке
            setTimeout(() => {
                window.location.href = url;
            }, 300);
        });
    });
</script>
