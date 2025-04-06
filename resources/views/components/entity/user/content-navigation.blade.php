<div id="user-content-nav" class="{{ $indentStyles  }}">
    <div class="bg-white rounded-full py-1 px-7 w-f ull flex flex-row min-h-[44px] items-center justify-between">
        <ul id="user-content-links" class="flex flex-row gap-x-5 text-xs ">
            @foreach ($navigationNodes as $node)
                <li class="">
                    <x-shared.core.link :url="$node['url']" :text="$node['text']" :weight="$node['weight']" :active="$node['active']" size='small' />
                </li>
            @endforeach
        </ul>
{{--        <div id="user-awards" class="flex flex-row gap-x-1.5">--}}
{{--            @for ($i = 0; $i < 3; $i++)--}}
{{--                <x-entity.user.lib.award-item iconurl='icons/user/award.svg' />--}}
{{--            @endfor--}}
{{--        </div>--}}
    </div>
</div>
