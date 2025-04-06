<div class="flex flex-row gap-x-1.5 max-sm:flex-wrap max-sm:gap-y-2">
    @foreach ($taglist as $tag)
        <x-shared.lib.items.tag :$tag :bgcolor="$bgcolor" />
    @endforeach
</div>
