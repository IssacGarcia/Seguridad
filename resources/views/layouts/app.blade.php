<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? config('app.name') }}</title>
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <x-navbar />
        {{ $slot }}
        @livewireScripts

        @auth
        <script>
            console.log('Logged in as {{ auth()->user()->name }}');
        </script>
        @endauth

        <script>
            window.addEventListener('alert', event => {
                alert(event.detail.message);
            });
        </script>

        <!-- reCAPTCHA v2 Script -->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
            function recaptchaVerified(response) {
                Livewire.emit('recaptchaVerified' , response);
            }
        </script>
    </body>
</html>
