<form id="resume-add-workplace" class="mb-12 hidden" method="POST" action="/resume/workplace">
    @csrf
    <div id="resume-add-workplace" class="mb-10">
        <div id="edit-content" class="grid grid-cols-12 auto-rows-auto gap-3 mb-9 max-md:grid-cols-8 max-sm:grid-cols-4">
            <div class="col-span-4">
                <x-shared.form.textInput :elementData="$formData['organization_name']" />
            </div>
            <div class="col-span-4">
                <x-shared.form.textInput :elementData="$formData['position']" />
            </div>
            <div class="col-span-4">
                <x-shared.form.textInput :elementData="$formData['duties']" />
            </div>
            <div class="col-span-4 sm:row-start-2">
                <x-shared.form.datepicker :elementData="$formData['date_employment']" />
            </div>
            <div class="col-span-4 sm:row-start-2">
                <x-shared.form.datepicker :elementData="$formData['date_dismissal']" />
            </div>
            <div class="sm:row-span-3 sm:row-start-3 sm:col-span-12 max-md:col-span-8 max-sm:col-span-4">
                <x-shared.form.textarea :elementData="$formData['description']" />
            </div>
        </div>
        <x-shared.core.button text="Добавить" />
    </div>
    <x-shared.lib.divider />
</form>
