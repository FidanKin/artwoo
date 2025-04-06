<div @class([
    'filter bg-primaryColor rounded-full shrink-0 flex items-center justify-center cursor-pointer',
    'w-[38px] h-[38px]' => $size === 'normal',
    'w-[30px] h-[30px]' => $size === 'sm'
    ]) data-micromodal-trigger="modal-global-filter"
>
    <div class="lines mx-auto">
        <span class="h-0.5 block w-[17px] bg-white mx-auto"></span>
        <span class="h-0.5 block w-[13px] my-0.5 bg-white mx-auto"></span>
        <span class="h-0.5 block w-[7px] bg-white mx-auto"></span>
    </div>
</div>
