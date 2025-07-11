
<div class="custom-tooltip-container">
    <button class="btn btn-info btn-sm"
            onmouseover="changeIcon(this, 'fa fa-link')"
            onmouseout="changeIcon(this, 'fa fa-link')"
            onclick="copyText(this)"
            data-text="{{ $audit->url }}">
        <i class="fa fa-link"></i>
    </button>
    <span class="custom-tooltip">{{ $audit->url }}</span>
</div>


<script>
    function changeIcon(button, newIcon) {
        const icon = button.querySelector("i");
        icon.className = `fa ${newIcon}`;
    }

    function copyText(button) {
        const text = button.getAttribute("data-text");

        navigator.clipboard.writeText(text).then(() => {
            const customtooltip = button.nextElementSibling;
            customtooltip.textContent = "Скопировано!";
            setTimeout(() => {
                customtooltip.textContent = "Нажмите, чтобы скопировать";
            }, 1500);
        }).catch(err => console.error("Ошибка копирования: ", err));
    }
</script>


