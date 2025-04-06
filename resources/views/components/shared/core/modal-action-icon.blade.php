<div class="modal-action inline">
    <button class="modal-trigger-element bg-black rounded-full block leading-3 p-2"
            data-micromodal-trigger="modal-{{ $id }}"
    >
        <img class="scale-75 brightness-200 max-w-none" src="{{ url("/icons/{$iconname}.svg") }}">
    </button>
</div>
<x-widgets.lib.modal-custom :$id :$title :$actionUrl :$actionLabel :$closeText :$method>
    {{ $slot }}
</x-widgets.lib.modal-custom>
