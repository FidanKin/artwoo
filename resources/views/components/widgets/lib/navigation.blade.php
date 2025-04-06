<span id="navigation" class="inline-block px-2 mt-4">
@foreach($nodes as $node)
    <a href="{{ $node->path }}" class="{{ $node->active ? 'text-slate-600 font-bold' : 'text-primaryColor'}}">{{ $node->title }}</a>
    @if (! $loop->last)
        <span class="text-slate-500 font-bold"> / </span>
    @endif
@endforeach
</span>
