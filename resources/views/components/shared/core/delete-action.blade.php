<div class="delete-action">
    <button class="modal-trigger-element" data-micromodal-trigger="modal-{{ $id }}">
        <div class="flex flex-row items-center">
            <div class="delete-icon">
                <img class="scale-75" src="/icons/delete.svg">
            </div>
            <span class="ml-2 text-md-gray hover:text-sm-gray ease-linear duration-100">
                {{ $text }}
            </span>
        </div>
    </button>
</div>
<x-widgets.lib.modal :$id
                     title="{{ __('core.actions.confirm_action') }}"
                     content="{{ $content }}"
                     :actionUrl="$url"
                     actionLabel="{{ __('core.delete') }}"
/>
