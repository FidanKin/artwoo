<div data-content="modal-adv" class="max-w-2xl">
    <div class="content mb-8">
        <p class="font-light text-black text-sm mb-5">
            {{ $description }}
        </p>
        @if($attentiontext)
            <p class="font-medium text-black text-sm">
                {{ $attentiontext }}
            </p>
        @endif
    </div>
    @if($actiontext)
        <x-shared.core.button :text="$actiontext" color="white" weight="medium" size="sm" padding="md" />
    @endif
</div>
