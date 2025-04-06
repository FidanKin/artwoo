<article class="resume-item rounded-card bg-white flex flex-row justify-between
            overflow-hidden">
    <div class="content p-3.75 basis-10/12">
        <header class="flex flex-row">
            @if($isEditing)
                <x-shared.lib.base-icon iconurl="{{ url('/icons/color-setting.svg') }}" backgroundColor="transparent"/>
            @endif
            <div class="titles flex flex-col ml-3">
                <x-shared.core.title size="h4"
                                     weight="medium"
                                     :text="$title"
                                     color="primary"
                                     containerClasses="leading-none"
                />
                <span class="text-xs text-strong-gray">
                    {{ $timeworked }}
                </span>
            </div>
        </header>
        <p class="mt-4 text-sm text-sm-gray">
            <span class="text-strong-gray">{{ __("resume.duties") }}:</span> {{ $duties }}
        </p>
        <p class="mt-4 text-sm text-sm-gray">
            <span class="text-strong-gray">{{ __("resume.description_short") }}:</span> {{ $description }}
        </p>
    </div>
    @if($isEditing)
        <button class="delete-button w-[85px] bg-[#E8EEF0] relative cursor-pointer hover:bg-[#E3E3E3] transition group"
                data-action-method="delete" data-action-request="resume/workplace?id={{ $workplaceID }}">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 group-hover:invert">
                <x-shared.lib.base-icon iconurl="{{ url('icons/delete.svg') }}" backgroundColor="transparent" />
            </div>
        </button>
    @endif
</article>
