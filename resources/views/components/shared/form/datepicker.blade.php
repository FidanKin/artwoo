<div class="form-element py-1.5" data-form-type='datepicker'>
  <div class="relative z-0" data-area="form-element-wrapper">
    <input id="{{ $id }}"
      datepicker
      name = "{{ $name }}"
      data-default-value="{{ $options['default_date'] ?? '' }}"
      type="text"
      {{
        $attributes->class([
          " block py-3.75 px-6 w-full text-xs text-black
            border-0 appearance-none dark:text-white
            dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0
            peer rounded-full $bgColor",
            $invalidInputColorBg => $errors->has($name),
          'text-white' => $errors->has($name)
        ])
      }}
      value = "{{ !empty(old($name)) ? old($name) : $value }}"
    >
      <label for="{{ $id }}"
        {{ $attributes->class([
        'absolute text-xs text-gray-600
          duration-300 transform top-3.75 left-6 -z-10 origin-[0]
          peer-focus:left-6 peer-focus:rounded-full peer-focus:dark:text-blue-500
          peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0
          peer-focus:scale-75 peer-focus:-translate-y-4 z-50 form-control-label',
          $invalidInputColorText => $errors->has($name)
        ]) }}
        >
        @error($name) {{ $message }} @else {{ $placeholder }} @enderror
      </label>
      <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
        <img class="scale-75" src="{{ config('url') }}/icons/calendar.svg">
     </div>
  </div>
</div>
