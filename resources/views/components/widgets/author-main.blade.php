@aware(['userNavigation'])
<x-layout.secondary.content-base>
    <x-entity.user.intro>
        @if($author['resume_link'])
            <x-shared.lib.switcher actionOn="{{ '/resume/'.$author['id'] }}" dataon="{{ __('user.switcher_resume') }}"
                                   actionOff="{{ '/author/'.$author['id'] }}" dataoff="{{ __('user.switcher_artworks') }}"
                                   checked="{{ false }}"
            />
        @endif
        @if($isUserSelf)
            <div>
                <x-shared.core.button-link url="/my/edit" text="{{ __('user.edit_profile') }}" fontweight="font-bold" darkBg="{{ true }}" />
            </div>
        @endif
    </x-entity.user.intro>
    @if(!empty($author['about']))
        <div class="mb-5">
            <p class="text-sm text-strong-gray">
                <span class="font-bold">{{ __('user.about_me') }}:</span> {{ $author['about'] }}
            </p>
        </div>
        <div class="p-0.5"></div>
    @endif
    <x-entity.user.content-navigation :userNavigation="$userNavigation" />
    @if($isUserSelf)
        <div id="add-artwork-interface" class="w-full text-center mb-4">
            <div class="w-60 mx-auto">
                <x-shared.core.button-link url="/artwork/edit" text="{{ __('artwork.actions.create') }}"
                                           fontweight="font-bold" darkBg="{{ false }}" />
            </div>
        </div>
    @endif
    <x-widgets.collections.artwork :items="$artworks" loadbutton="{{ true }}" loadbuttondark="{{ false }}" />
</x-layout.secondary.content-base>
