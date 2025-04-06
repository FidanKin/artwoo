<div class="p-3.75 bg-white rounded-card flex flex-row justify-between items-center max-md:flex-col max-md:gap-y-4" data-content="message-card">
    <x-entity.user.lib.user-info id="{{ $userId }}" login="{{ $login }}" icon="{{ $userIconUrl }}" age="{{ $userAge }}" />
    <div class="body flex flex-row basis-6/12 gap-x-2.5 justify-between max-md:flex-col max-md:gap-y-2.5">
        <div class="message-text">
            <p class="text-sm text-sm-gray">
                {{ $messagetext }}
            </p>
        </div>
        <div class="message-date">
            <span class="text-black text-sm font-medium">{{ $messagedate }}</span>
        </div>
    </div>
    <div class="actions flex flex-row items-center gap-x-2.5">
        <x-shared.core.button-link url="/chat/{{ $chatId }}" fontweight="font-medium" darkBg="{{ false }}" text="Открыть" />
    </div>
</div>
