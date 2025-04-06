<div class="switch-element">
    <span class="switch">
        <input id="switcher" class="hover:cursor-pointer" type="checkbox" data-on="{{ $dataon }}" data-off="{{ $dataoff }}"
               data-action-on="{{ $actionOn }}" data-action-off="{{ $actionOff }}" @checked($checked) />
        <label for="switcher"></label>
    </span>
</div>
