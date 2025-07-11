    <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="{{ $shareUrl }}">
        <a class="a2a_button_telegram a2a_button"></a>
        <a class="a2a_button_whatsapp a2a_button"></a>
        <a class="a2a_button_vk a2a_button"></a>
        <a class="a2a_button_viber a2a_button"></a>
        <a class="a2a_button_copy_link a2a_button"></a>
        <a class="a2a_dd a2a_button" href="https://www.addtoany.com/share"></a>
    </div>

<script>
    var a2a_config = a2a_config || {};
    a2a_config.locale = "ru";
    a2a_config.num_services = 10;
    a2a_config.no_analytics = true; // Отключение сбора аналитики

    a2a_config.callbacks = a2a_config.callbacks || [];
    a2a_config.callbacks.push({
        share: function(data) {
            let utmSource = data.service.toLowerCase();
            let utmUrl = data.url +
                `?utm_source=${utmSource}` +
                `&utm_medium=social` +
                `&utm_campaign=share`;

            data.url = utmUrl;
            return data;
        }
    });
</script>

<script defer src="https://static.addtoany.com/menu/page.js"></script>
