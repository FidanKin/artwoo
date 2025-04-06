@if($returnBack)
    <a href="{{ $backUrl }}">
@endif

    <button type="button" id="item-close" class="p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100">
        <span class="sr-only">Close menu</span>
        <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 40 40" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 36L36 6M6 6l30 30" />
        </svg>
      </button>
@if($returnBack)
    </a>
@endif
