<article id="artwork-full" class="pt-px">
    <div class="grid grid-cols-4 gap-4 max-md:grid-cols-2 max-mm:grid-cols-1">
            @foreach ($artwork['image_paths'] as $path)
                <a class="artwork-image-full max-md:mx-auto" href="{{ $path }}">
                    <img class="w-64 h-64 object-cover rounded" src="{{ $path }}" alt="alt"/>
                </a>
            @endforeach
    </div>
    @if($artwork['price'])
        <div class="before-description mt-3">
            <x-shared.core.price cost="{{ $artwork['price'] }}" />
        </div>
    @endif
    <x-entity.lib.description-base :description="$artwork['description']" />
</article>
