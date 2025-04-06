<div class="{{ $indentStyles }} bg-white rounded-card flex flex-row items-center justify-between max-md:flex-col
    max-md:gap-y-5 max-md:items-start" data-type="author-card">
    <div class="main flex flex-row gap-x-11 items-center max-sm:flex-col max-sm:gap-y-4 max-sm:items-start">
        <x-entity.user.lib.user-info id="{{ $author['id'] }}" login="{{ $author['login'] }}" icon="{{ url($author['avatar_icon']) }}"
                                     age="{{ $author['age'] }}" size="xs" artworktype="{{ $author['creativity_name'] }}" />
        <div class="img flex flex-row gap-x-2">
            @foreach($artworks as $id => $artwork)
                @if($id === 'empty')
                    @continue
                @endif
                <a href="/artwork/{{ $id }}" class="hover:scale-110">
                    <x-shared.lib.artwork-image pathToImage="{{ $artwork['image_url'] }}" imageType="small" />
                </a>
            @endforeach
        </div>
    </div>

    <div class="secondary flex flex-row gap-x-5 max-md:w-full">
        <x-shared.lib.buttonLink url="/author/{{ $author['id'] }}" text="Профиль" size="sm" />
    </div>
</div>
