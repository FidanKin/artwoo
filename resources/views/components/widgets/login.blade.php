<section id="signup-component" class="max-w-lg">
    <x-shared.core.simple-back path="/" />
    <x-shared.core.title text="{{ __('auth.enter_title') }}" containerClasses='mt-8 mb-9 text-center' weight="bold" />
    @if(session('status'))
        <x-shared.notification.simple.success id="repair_password" message="{{ session('status') }}" />
    @endif
    <form action="/login" method="POST" id="authorization-form">
        @csrf
        @if(session('form_save_error'))
            <div class="my-1">
                <span class="px-6 text-invalid-value text-base text-xs">
                    * {{ session('form_save_error') }}
                </span>
            </div>
        @endif
        <x-shared.form.textInput :elementData="$formData['email']" bgColor='sm-dark' />
        <x-shared.form.passwordInput :elementData="$formData['password']" />
        <x-shared.form.submit-input text="{{ __('auth.login') }}" name='submit' includeMt={{ true }} />
    </form>
    <div class="mt-4">
        <span class="text-center inline-block w-full text-sm font-bold">
            {!!  __('auth.no_account_register') !!}
        </span>
        <span class="text-center inline-block w-full text-sm">
            <span>{{ __('user.forgot_password') }}</span>
            <x-shared.core.link text="{{ __('user.actions.recover_password') }}" url="{{ route('password.request') }}"
                                color="primary" underline="{{ true }}" size="default" />
        </span>
    </div>
</section>
