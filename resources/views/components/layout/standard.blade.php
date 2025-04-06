<x-layout.lib.header />
<main id="main"
    {{
        $attributes->class(["bg-base-gray" => $hasEditSublayout || $bgGray, 'overflow-hidden' => $overflowHidden])
    }}
>
    <div class="container mx-auto max-w-screen-lg {{ $indentStyles }}">
        <div class="content px-5">
            @if(!empty($navigationNodes))
                <x-widgets.lib.navigation :nodes="$navigationNodes" />
            @endif
            {{ $slot }}
        </div>
    </div>
</main>

@if (!$hasEditSublayout || $hasfooter)
    <footer class="footer">
        <div class="container mx-auto max-w-screen-lg before:content-[''] before:h-px before:w-full
            before:bg-[#C5DCEC] before:block">
            <div class="footer-content flex flex-row justify-between py-9 max-sm:gap-y-5 max-sm:flex-col-reverse">
                <div class="company max-sm:mx-auto">
                    <div class="logo mb-3 w-36">
                        <x-shared.core.logo />
                    </div>
                    <span class="block max-sm:text-center">@ 2024 <span class="font-bold">"Artwoo"</span></span>
                    <span class="block max-sm:text-center">Все права защищены</span>
                </div>

                <!-- Полезные ссылки -->
                <div id="footer-more-info" class="flex flex-row max-sm:justify-around max-mm:flex-col max-mm:gap-y-2.5">
                    <div class="flex flex-col mm:mr-3 gap-y-2.5">
                        <x-shared.core.link url='/blog/about' text="{{ __('core.about_project') }}" />
                        <x-shared.core.link url='/pages/contacts' text="{{ __('core.contacts_info') }}" />
                        <x-shared.core.link url='/blog/donation' text="{{ __('core.help') }}" />
                        <x-shared.core.link url='/blog/documentation' text="{{ __('core.pages.blog.documentation.title') }}" />
                    </div>
                    <div class="flex flex-col mm:ml-3 gap-y-2.5">
                        <x-shared.core.link url='/blog' text="{{ __('core.blog') }}" />
                        <x-shared.core.link url='/blog/founders' text="{{ __('core.founders') }}" />
                        <x-shared.core.link url='/pages/privacy-policy' text="{{ __('core.politics') }}" />
                        <x-shared.core.link url='/pages/privacy-cookie' text="{{ __('core.pages.privacy_cookie.title') }}" />
                    </div>
                </div>

            </div>
        </div>
        </div>
    </footer>
@endif
