<header id="header">
    <div class="container mx-auto py-[50px] px-[90px] max-sm:py-5">
        <div id="header-content" class="flex flex-nowrap justify-between max-sm:flex-col max-sm:items-center max-sm:gap-y-2
            max-lg:flex-col max-lg:items-center max-lg:gap-y-2.5" >
            <div class="flex items-center">
                <div id="logo-header" class="pt-1 pb-1">
                    <a href="/">
                        <x-shared.core.logo />
                    </a>
                </div>
                <!-- Logo -->
            </div>
            <div id="nav-menu" class="flex flex-row items-center xl:pl-[124px]">
                <div class="mx-6 ">
                    <x-shared.core.link url='/' text="{{ __('core.artworks') }}" />
                </div>
                <div class="mx-6 ">
                    <x-shared.core.link url='/author' text="{{ __('core.authors') }}" />
                </div>
                <div class="mx-6 ">
                    <x-shared.core.link url='/blog' text="{{ __('core.blog') }}" />
                </div>
                <div class="mx-6 ">
                    <x-shared.core.link url='/pages/contacts' text="{{ __('core.pages.contact.title') }}" />
                </div>
            </div>
            <div id="global-action " class="flex items-center">
                <!-- какие - то глобальные настройки -->
{{--                @if($user)--}}
{{--                    <div class="icon px-1 relative">--}}
{{--                        <img src="/icons/header/settings.svg">--}}
{{--                        <img class="absolute z-10 top-1 left-2" src="/icons/header/setting-form.svg">--}}
{{--                    </div>--}}
{{--                @endif--}}
            </div>
            @if($user)
                <div id="user-menu" class="flex flex-row items-center">
                    <!-- Пользовательское меню -->
                    <div class="px-2">
                        <a id="header-artwork-edit-link" class="interactive-link" href="/artwork/edit">
                            <img class="img " src="/icons/header/artwork-before.png">
                        </a>
                    </div>
                    <div class="px-2">
                        <a href="/chat">
                            <img class="hover:scale-110" src="/icons/header/message.svg" />
                        </a>
                    </div>
                    <div class="px-2">
                        <a href="/reference">
                            <img class="hover:scale-110" src="/icons/header/refs.svg" />
                        </a>
                    </div>
                </div>

                <div id="profile" class="flex flex-row items-center">
                    <a href="/my" class="user-login mr-1 font-semibold hover:text-primaryColor transition ">
                        <span class="">{{ $user->login }}</span>
                    </a>
                    <div id="user-icon" class="relative">
                        <div class="block w-[41px] h-[41px] rounded-full p-px overflow-hidden">
                            <img class="block ml-auto mr-auto" src="{{ $user->getIconUrl() }}" />
                        </div>
                    </div>
                    <div class="exit-button ml-1">
                        <a href="/logout" class="hover:filter hover:contrast-50">
                            <img src="/icons/header/exit.svg" />
                        </a>
                    </div>
                </div>
            @else
                <div class="p-2 bg-gradient-to-r from-blue-300 to-fuchsia-400 rounded">
                    <a href="/login" class="font-semibold text-white hover:text-primaryColor hover:transition">
                        {{ __('auth.login') }}
                    </a>
                    <span class="text-white"> / </span>
                    <a href="/signup" class="font-semibold text-white hover:text-primaryColor hover:transition">
                        {{ __('auth.signup') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</header>
