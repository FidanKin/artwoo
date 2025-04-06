<div class="form-element py-1.5" data-form-type='file'>
    <div class="relative z-0" data-area="form-element-wrapper">
        @error($name)
            <div class="form-element-errors">
                <span class="text-xs text-invalid-value">* {{ $message }}</span>
            </div>
        @enderror

        @foreach($errors->get($name . '.*') as $messages)
            @foreach($messages as $message)
                <div class="form-element-errors">
                    <span class="text-xs text-invalid-value">* {{ $message }}</span>
                </div>
            @endforeach
        @endforeach

        <div class="file_upload_area flex flex-row">
            <div class="files_show flex flex-row flex-wrap gap-2">
                @foreach($options['uploaded'] as $imageurl)
                    <div class="file-upload-container w-[100px] max-w-[120px] h-auto overflow-hidden rounded
                        relative inline-block p-2 border border-md-gray border-solid flex flex-row items-center justify-center">
                        <div class="h-full">
                            <div class="upload-item-file static block leading-none max-h-full relative m-auto object-contain
                                overflow-hidden flex-none group">
                                <button type="button" class="float-right bg-white rounded-md p-1 inline-flex items-center justify-center
                                    text-gray-500 hover:bg-gray-200 focus:outline-none mb-2" data-action-code="delete">
                                    <span class="sr-only">Close menu</span>
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                <img src="{{ $imageurl }}" data-image-blob="0" class='block static object-contain overflow-hidden max-w-[86px] max-h-[86px] ' />
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <label class="ml-2 text-xs text-black w-[102px] h-[102px] text-center align-middle
                        appearance-none border border-md-gray border-dashed bg-white rounded-2xl p-4
                        hover:border-primaryColor"
                    for="input-{{ $name }}"
            >
                <span class="upload-wrapper flex flex-col items-center justify-center text-center h-full cursor-pointer">
                    <span class="icon-plus">
                        <svg viewBox="64 64 896 896" focusable="false" data-icon="plus" width="1em" height="1em"
                             fill="currentColor" aria-hidden="true">
                            <path d="M482 152h60q8 0 8 8v704q0 8-8 8h-60q-8 0-8-8V160q0-8 8-8z"></path>
                            <path d="M192 474h672q8 0 8 8v60q0 8-8 8H160q-8 0-8-8v-60q0-8 8-8z"></path>
                        </svg>
                    </span>
                    <span class="text-add">
                        {{ $placeholder }}
                    </span>
                </span>
            </label>
        </div>
            <input type="file"
                class='hidden filepicker-simple'
                id="input-{{ $name }}"
                name ="{{ $inputName }}"
                value ="{{ !empty($value) ? $value : old($name) }}"
                @if(!empty($multiple)) multiple @endif
            />

    </div>
</div>
