<div class="flex flex-col p-4 rounded">
    <div class="w-100">
        <x-shared.form.textInput  :elementData="$formData['name']" bgColor="sm-dark"/>
    </div>
    <div class="w-100">
        <x-shared.form.textarea :elementData="$formData['description']" bgColor="bg-slate-100" rows="3"/>
    </div>
    <div class="w-100">
        <x-shared.form.checkbox :elementData="$formData['automatic_deletion']" bgwhite="{{ false }}" />
    </div>
    <div class="w-100 mt-3">
        <x-shared.form.submit-input name="{{ __('core.actions.submit') }}" text="{{ __('core.actions.create') }}" />
    </div>
</div>