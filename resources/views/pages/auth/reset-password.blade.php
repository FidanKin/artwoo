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
        @error('status')
            <x-shared.notification.simple.failed id="reset-password" :$message />
        @enderror
        <form method="POST" id="reset-password" class="ml-auto mr-auto max-w-card" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" class="hidden" name="token" value="{{ $token }}" />
            <x-shared.form.text-input :elementData="$formData['email']" bgColor='sm-dark' />
            <x-shared.form.password-input :elementData="$formData['password']" bgColor='sm-dark' />
            <x-shared.form.password-input :elementData="$formData['password_confirmation']" bgColor='sm-dark' />
            <span class="mb-4 block"></span>
            <x-shared.core.button text="{{ __('user.actions.recover_password') }}" fullWidth="{{ true }}" />
        </form>

        <x-shared.core.front-stack />
    </section>
</x-layout.standard>
@vite('resources/js/pages/reset-password.js')
</body>
</html>
