{{--
    Интерфейс отображения вводного информациионого блока контента (блок пользователя)
    Здесь цвет кнопки отправки сообщения зависит от цвета самого блока
        Если блок белый, то цвет кнопки отправки сообщения синий
        Иначе черный
 --}}
@aware(['canSendMessage', 'author', 'formData'])
<div class="user-intro my-4 inline-block w-full">
    <div class="user-intro__wrapper flex flex-row justify-between {{ $styleClasses }} rounded-full max-sm:flex-col max-sm:gap-y-4
        max-sm:items-center">
        <x-entity.user.lib.user-info :id="$author['id']" :login="$author['login']" :icon="$author['avatar_icon']"
            :artworktype="$author['creativity_name']" :age="$author['age']" :socials="$author['socials']" moreinfo="{{ true }}" />
        <div class="user-action flex flex-row gap-x-3 items-center">
            {{ $slot }}
            @if($canSendMessage)
                <x-shared.core.modal-action      id="add-references-to-folder"
                                                 text="{{ __('chat.send_message') }}"
                                                 title="{{ __('chat.send_message') }}"
                                                 actionUrl=""
                                                 method=""
                                                 actionLabel=""
                                                 closeText=""
                >
                    <form method="POST" action="/chat/message">
                        @csrf
{{--                        <x-shared.form.textarea :elementData="$formData['chat']" bgColor="bg-slate-100" />--}}
                        <x-shared.form.textarea :elementData="$chatForm" bgColor="bg-slate-100" />
                        <input type="hidden" name="to_user" value="{{ $author['id'] }}" />
                        <x-shared.form.submit-input name="submit" text="{{ __('core.actions.send') }}" />
                    </form>
                </x-shared.core.modal-action>
            @endif
        </div>
    </div>
</div>
