@props(['grid_df' => 'col-span-4 max-md:col-span-6 max-sm:col-span-12'])

<div id="edit-content" class="grid grid-cols-12 gap-3">
    <div class="{{ $grid_df }}">
        <x-shared.form.textInput :elementData="$formData['email']" />
    </div>
    <div class="{{ $grid_df }}">
        <x-shared.form.select :elementData="$formData['creativity_type']" />
    </div>
    <div class="{{ $grid_df }}">
        <x-shared.form.textInput :elementData="$formData['login']" />
    </div>
    <div class="{{ $grid_df }}">
        <x-shared.form.textInput :elementData="$formData['birthday']" />
    </div>
    <div class="{{ $grid_df }}">
        <x-shared.form.checkbox :elementData="$formData['freelance']" />
    </div>
    <div class="col-span-12 w-full">
        <x-shared.form.filepicker :elementData="$formData['user_picture']" multiple="{{ false }}"/>
    </div>
    <div class="col-span-12 row-span-3">
        <x-shared.form.textarea :elementData="$formData['about']" />
    </div>
</div>
