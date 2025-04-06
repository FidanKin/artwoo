{{-- Просматриваем ли какую - то одну запись ? isViewSingleItem --}}
{{-- Можем перейти к редактированию записи ? canManage --}}
{{-- Мы находимся на редактируемой формы ? isEditable --}}
<section id="main"
    {{
        $attributes->class([
            $indentStyles,
            'w-full min-h-full' => $isEditable
        ])
    }}
>

        <header
            {{
                $attributes->class([
                    'flex flex-row justify-between items-center max-sm:flex-col my-4' => $isEditable || $canManage ||
                        $isViewSingleItem || $headerSlot
                ])
            }}
        >
            @if($title)
                <x-shared.core.title size='h2' weight="bold" :text="$title" color="multi" />
            @endif
            @if($headerSlot)
                {{  $headerSlot }}
            @endif
        </header>


    @if ($isEditable)
        {{-- Форма редактирования --}}
        <div id="edit-form" class="pt-5">
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif


    @if ($canManage && $isViewSingleItem)
        <div class="flex flex-row items-center gap-x-8 mt-16">
            <x-shared.lib.button-link backgroundColor="primary" text="{{ __('core.edit') }}" :url="$actions['edit']"
                padding="btn-md-high"/>
        </div>
    @endif

</section>
