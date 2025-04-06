<x-layout.secondary.content-base :$actions isViewSingleItem="{{ true }}" :$canManage>
    <x-entity.user.intro>
        <x-shared.lib.switcher actionOn="{{ '/resume/'.$author['id'] }}" dataon="{{ __('user.switcher_resume') }}"
                               actionOff="{{ '/author/'.$author['id'] }}" dataoff="{{ __('user.switcher_artworks') }}" checked="{{ true }}" />
    </x-entity.user.intro>

    <x-widgets.lib.contentMetaInfo :$metaInfo />
    {{-- Навыки соискателя --}}
    <div id="skills" class="space-x-2">
        @foreach($skills as $skill)
            <x-shared.lib.items-list :text="$skill" />
        @endforeach
    </div>
    <div class="workplaces my-8 space-y-3">
        @if(!empty($workplaces))
            @foreach($workplaces as $workplace)
                <x-widgets.cards.resume-workplace
                    isEditing="{{ false }}"
                    :title="$workplace->title"
                    :timeworked="$workplace->duration"
                    :description="$workplace->description"
                    :duties="$workplace->duties"
                    :workplaceID="$workplace->id"
                />
            @endforeach
        @else
            <span class="text-sm text-strong-gray"> {{ __('resume.no_workplace') }} </span>
        @endif
    </div>
</x-layout.secondary.content-base>
