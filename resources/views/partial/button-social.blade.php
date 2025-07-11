
<div class="text-center"  role="toolbar" aria-label="Toolbar with button groups" >
    <div class="btn-group me-8" role="group" aria-label="First group">
        <a href="{{ url('auth/google') }}">
            <button class="google-btn" >
                <svg xmlns="http://www.w3.org/2000/svg" height="40" width="40" viewBox="0 0 488 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <path fill="#ffffff" d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"/></svg>
            </button>
        </a>

    </div>
    <div class="btn-group me-8 " role="group" aria-label="Second group" >

        <a href="{{ url('auth/yandex') }}" class="yandex-btn">
            <svg width="40" height="40" viewBox="0 0 44 44" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <rect width="44" height="44" rx="10" fill="#FC3F1D"></rect>
                <path
                    d="M24.7406 33.9778H29.0888V9.04445H22.7591C16.3928 9.04445 13.0537 12.303 13.0537 17.1176C13.0537 21.2731 15.2186 23.6164 19.0531 26.1609L21.3831 27.6987L18.3926 25.1907L12.4666 33.9778H17.1817L23.5113 24.5317L21.3097 23.0672C18.6494 21.2731 17.3468 19.8818 17.3468 16.8613C17.3468 14.2069 19.2182 12.4128 22.7775 12.4128H24.7222V33.9778H24.7406Z"
                    fill="white"></path>
            </svg>
        </a>

    </div>


{{--    <div class="btn-group" role="group" aria-label="Third group">--}}
{{--        <div>--}}
{{--            <script src="https://unpkg.com/@vkid/sdk@<3.0.0/dist-sdk/umd/index.js"></script>--}}
{{--            <script type="text/javascript">--}}
{{--                if ('VKIDSDK' in window) {--}}
{{--                    const VKID = window.VKIDSDK;--}}

{{--                    const state = Math.random().toString(36).substring(7);--}}

{{--                    VKID.Config.init({--}}
{{--                        app: 52961038,--}}
{{--                        redirectUrl: 'https://staging.testcorporation.ru/auth/vk/callback',--}}
{{--                        state: state,--}}
{{--                        scope: 'email phone',--}}
{{--                    });--}}


{{--                    const oneTap = new VKID.OneTap();--}}

{{--                    oneTap.render({--}}
{{--                        container: document.currentScript.parentElement,--}}
{{--                        fastAuthEnabled: false,--}}
{{--                        showAlternativeLogin: true,--}}
{{--                        styles: {--}}
{{--                            borderRadius: 10,--}}
{{--                            width: 40,--}}
{{--                            height: 40--}}
{{--                        }--}}
{{--                    })--}}
{{--                        .on(VKID.WidgetEvents.ERROR, vkidOnError)--}}
{{--                        .on(VKID.OneTapInternalEvents.LOGIN_SUCCESS, function (payload) {--}}
{{--                            const code = payload.code;--}}
{{--                            const deviceId = payload.device_id;--}}

{{--                            VKID.Auth.exchangeCode(code, deviceId)--}}
{{--                                .then(vkidOnSuccess)--}}
{{--                                .catch(vkidOnError);--}}
{{--                        });--}}

{{--                    function vkidOnSuccess(data) {--}}
{{--                        // Обработка полученного результата--}}
{{--                    }--}}

{{--                    function vkidOnError(error) {--}}
{{--                        // Обработка ошибки--}}
{{--                    }--}}
{{--                }--}}
{{--            </script>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
