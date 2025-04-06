<div class="reference-item max-w-card mb-9">
    <div class="w-fit">
        <a href="{{ $reference['image_url'] }}" target="__blank">
            <a class="reference-image-preview" href="{{ $reference['image_url'] }}">
                <img class="w-64 h-64 object-cover rounded" src="{{ $reference['image_url'] }}" alt="alt" />
            </a>
        </a>
        <div class="reference-item__description mt-3 leading-none flex flex-row">
            <div class="info flex flex-row justify-between items-center w-full">
                <div class="description">
                    <x-shared.core.title size='h4' weight="medium" text="{{ $reference['name'] }}" />
                </div>

                @if($displayActions)
                    <div class="flex flex-row gap-x-0.5 p-0.5 cursor-pointer reference-item-actions">
                        <span class="w-1.5 h-1.5 bg-high-gray block rounded-full"></span>
                        <span class="w-1.5 h-1.5 bg-high-gray block rounded-full"></span>
                        <span class="w-1.5 h-1.5 bg-high-gray block rounded-full"></span>
                        <div class="tooltip-template hidden">
                            <ul class="bg-white border rounded text-sm">
                                <li class="">
                                    <form action="/reference/item/delete/{{ $reference['id'] }}" method="POST">
                                        @csrf
                                        <input type="submit" class="cursor-pointer px-2 py-1 hover:bg-gray-100" value="Удалить">
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
