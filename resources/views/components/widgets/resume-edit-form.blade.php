
<form id="{{ $formid }}" method="POST" action="/resume/edit" >
    @csrf
    <div id="resume-main-settings" class="{{ $indentStyles  }}">
        <div class="first-level flex flex-row max-md:flex-col">
            <div class="basis-1/3">
                <x-shared.form.autocomplete :elementData="$formData['skills']" />
            </div>
            <div class="basis-1/3">
                <x-shared.form.select :elementData="$formData['preferred_work']" />
            </div>
        </div>

        <div class="second-level flex flex-row gap-x-8 mb-4 max-mm:flex-col">
            <x-shared.form.checkbox :elementData="$formData['has_art_education']" />
            <x-shared.form.checkbox :elementData="$formData['has_pedagogical_education']" />
        </div>
        <x-shared.core.button text="Сохранить" />
    </div>

</form>
