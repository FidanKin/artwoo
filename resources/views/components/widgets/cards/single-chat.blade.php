<section id="single-chat" class="">
    <div class="message-wrapper space-y-4.5 max-h-90 overflow-y-scroll">
        @foreach($messages as $message)
            <x-widgets.cards.message-item
                    messagetext="{{ $message['message'] }}"
                    owner="{{ $message['viewer_message'] }}"
                    userIcon="{{ $message['user_icon'] }}"
                    createdAt="{{ $message['created_at'] }}"
            />
        @endforeach
    </div>
    <span class="my-12 p-px">
        <x-shared.lib.divider />
    </span>
    <form id="send-message" method="post" name="send_message" action="/chat/message">
        @csrf
        <input type="hidden" name="to_user" value="{{ $toUserId }}" />
        <x-shared.form.textarea :elementData="$formData['message']" rows="3"/>
        <x-shared.form.submitInput name="submit" text="{{ __('chat.send_message') }}"
                                   isFullWidth="{{ false }}"/>
    </form>
</section>
