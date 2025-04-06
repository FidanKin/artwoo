<div class="modal-action inline">
    <button class="modal-trigger-element text-center rounded-full block leading-3 px-6 py-3 hover:bg-black transition text-white text-bold bg-primaryColor hover:bg-black w-full"
            data-micromodal-trigger="modal-{{ $id }}"
    >
        {{ $text }}
    </button>
</div>
<x-widgets.lib.modal-custom :$id :$title :$actionUrl :$actionLabel :$closeText :$method>
    {{ $slot }}
</x-widgets.lib.modal-custom>
