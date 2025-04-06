@aware(['formData'])
<div class="flex flex-row items-center justify-between">
    <x-shared.form.submitInput name='submit' :text="$saveText" />
    @if(!empty($formData['hidden']['item_id']))
        <x-shared.core.deleteAction id="artwork-delete-u1ir" :$content :text="$deleteText" :url="$formData['actions']['delete']" />
    @endif
</div>
