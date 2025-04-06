<section id="edit-content" class="w-full py-10 min-h-full mb-20">
    <div id="edit-header" class="flex flex-row justify-between items-center">
        <x-shared.core.title :text="$title" />
        <x-shared.core.close-button />
    </div>
    <!-- Форма редактирования -->
    <div id="edit-form" class="pt-10">
        {{ $slot }}
    </div>
</section>
