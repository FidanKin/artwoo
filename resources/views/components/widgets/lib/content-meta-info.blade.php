<div id="content-meta-info" class="flex flex-row gap-x-3.5 mb-4 max-sm:flex-col max-sm:gap-y-4">
    @if (!empty($tag['text']) && !empty($tag['url']))
        <x-shared.lib.button-link :url="$tag['url']" backgroundColor="primary" :text="$tag['text']"
                                 padding="btn-sm-high" />
    @endif

    <x-shared.lib.entity-wrapper>
        <x-slot:left>
            {!! $maininfodisplay !!}
        </x-slot:left>
        <x-slot:right>
            {!! $secondaryinfodisplay !!}
        </x-slot:right>
    </x-shared.lib.entity-wrapper>
</div>
