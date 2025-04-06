<div
    @class([
        "rounded-imageBig p-6.5 flex flex-row justify-between",
        'bg-white w-11/12 ml-auto' => $owner,
        'bg-light-gray' => !$owner,
    ])
>
    <p class="text-sm text-black font-light basis-7/12">{{ $messagetext }}</p>
    <x-entity.user.lib.user-chat
            enablelogin="{{ false }}"
            login="dummy"
            icon="{{ $userIcon }}"
            status="{{ $createdAt }}"
            cardsize="mini"
    />
</div>
