<section id="edit-content" class="w-full py-10 bg-[#F2F5F6] min-h-full">
    <form id="{{ $formId }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(session('form_save_result'))
            <div class="my-1">
                <span class="px-6 text-invalid-value text-base text-xs">
                    * {{ session('form_save_result') }}
                </span>
            </div>
        @endif
        <div id="edit-header" class="flex flex-row w-full justify-between items-center ">
            <div id="edit-header-links" class="flex max-w-[325px] w-full flex-row justify-between"></div>

            <!-- Кнопки действия в шапке -->
            <div id="edit-header-actions">
                {{ $actions }}
            </div>
        </div>

        <!-- Форма редактирования -->
        <div id="edit-form">
            {{ $slot }}
        </div>
    </form>
</section>
