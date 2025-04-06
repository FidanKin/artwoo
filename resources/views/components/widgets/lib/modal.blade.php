@push('modals-area')
    <div class="modal modal-slide" id="modal-{{$id}}" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-{{$id}}-title">
                <header class="modal__header">
                    <h2 class="modal__title" id="modal-{{$id}}-title">
                        {{ $title }}
                    </h2>
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="modal-{{$id}}-content">
                    <p>
                        {{$content}}
                    </p>
                </main>
                <footer class="modal__footer">
                    @if($hasAction)
                        <form method="{{ $method }}" action="{{ $actionUrl }}" class="inline">
                            @csrf
                            <button class="modal__btn modal__btn-primary">{{ $actionLabel }}</button>
                        </form>
                    @endif
                    <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">{{ $closeText }}</button>
                </footer>
            </div>
        </div>
    </div>
@endpush
