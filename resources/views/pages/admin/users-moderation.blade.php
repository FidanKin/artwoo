<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Модерация пользователей</title>
    <!-- Fonts -->
    <x-shared.lib.favicon />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,300&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="font-roboto">
<x-layout.standard bgGray={{ true }}>
    <x-layout.lib.moderator-nav />
    <x-layout.secondary.content-base>
        <x-slot:headerSlot>
            <h2 class="text-h2">Модерация пользователей</h2>
        </x-slot:headerSlot>

        @if(session('success'))
            <div class="my-2 bg-teal-100 border border-teal-400 text-sm text-teal-800 rounded-lg p-4 dark:bg-teal-800/10 dark:border-teal-900 dark:text-teal-500"
                 role="alert" tabindex="-1" aria-labelledby="hs-soft-color-success-label">
                <span id="hs-soft-color-success-label" class="font-bold">Success</span> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="errors">
                <ul>
                @foreach($errors->all() as $error)
                        <li class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-rose-700" role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                <span class="font-medium">Danger alert!</span> {{ $error }}
                            </div>
                        </li>
                @endforeach
                </ul>
            </div>
        @endif
        <div class="flex flex-col flex-wrap">
            @foreach($users as $user)
                <div class="mb-5 border-b-2 p-2 border-black">
                    <form method="POST" action="/admin/moderation/users">
                        <input type="hidden" name="target_user" value="{{ $user->id }}">
                        @csrf
                        <div class="flex flex-col">
                            <p class="font-bold">User info:</p>
                            <div class="min-info border rounded p-4">
                                <img src="{{ url($user->getIconUrl()) }}" class="img w-10 h-12" />
                                <p>{{ $user->login }}</p>
                                <p class="block">Description: {{ $user->about }}</p>
                            </div>
                            <div class="block font-bold">Actions:</div>
                            <select required class="w-1/2 py-2 px-4 block rounded my-2" name="status">
                                @foreach($select as $value => $visible)
                                    <option value="{{ $value }}">{{ $visible }}</option>
                                @endforeach
                            </select>
                            <textarea required class="rounded p-2" name="comment" rows="5" cols="12" placeholder="Comment">

                            </textarea>
                        </div>
                        <input class="btn rounded p-2 mt-4 bg-primaryColor text-white cursor-pointer" type="submit" name="submit" value="Moderate" />
                    </form>
                </div>
            @endforeach
        </div>

        {{ $users->links() }}
    </x-layout.secondary.content-base>
</x-layout.standard>
</body>
<x-shared.variables.modal-area />
</html>
