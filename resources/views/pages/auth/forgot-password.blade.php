<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Сброс пароля</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,300&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body>
<x-layout.standard>
    <section class="my-20">
        <h2 class="text-3xl font-bold mb-4 text-center">{{ __('user.password_reset') }}</h2>

        @if(session('status'))
            <x-shared.notification.simple.success id="reset-password" message="{{ session('status') }}" />
        @endif

        <form method="POST" class="max-w-card text-center ml-auto mr-auto" action="{{ route('password.request') }}">
            @csrf

            @error('email')
                <x-shared.notification.simple.failed id="reset-password" :$message />
            @enderror
            <input type="email" name="email" class="block py-3.75 px-6 w-full text-xs text-black appearance-none focus:outline-none
                    focus:ring-0 peer rounded-full bg-slate-100 border-0 mb-2" placeholder="{{ __('user.email') }}" />
            <x-shared.core.button text="{{ __('user.actions.recover_password') }}" fullWidth="{{ true }}" />
        </form>

        <x-shared.core.front-stack />
    </section>
</x-layout.standard>
</body>
</html>
