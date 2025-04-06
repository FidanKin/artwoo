<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,300&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="font-roboto overflow-x-hidden">
<x-layout.lib.header />
<div class="h-screen w-screen bg-primaryColor pb-10 max-lg:px-10">
    <div class="flex flex-column justify-center items-center h-full">
        <div class="content flex flex-row justify-around items-center w-full">
            <div class="description flex flex-row gap-x-11 max-md:flex-col max-md:gap-y-4 items-center">
                <div class="error_num">
                        <span class="text-white text-8xl font-bold">
                            @yield('error_code')
                        </span>
                </div>
                <div class="error_description">
                    <div class="bg-[#4285F4] w-0.5"></div>
                    <div class="error_description max-w-md">
                        <h2 class="text-2xl text-white font-bold">@yield('short_text')</h2>
                        <span class="text-base text-white font-light">
                            @yield('full_text')
                        </span>
                    </div>
                </div>
                <x-shared.lib.button-link text="На главную страницу" url="/" size="big" backgroundColor="primary-dark"/>
            </div>
        </div>
    </div>
    <div class="error__image img bg-repeat-x h-6" style="background-image: url(/icons/logo-adv.svg)"></div>
</div>
</body>
</html>
