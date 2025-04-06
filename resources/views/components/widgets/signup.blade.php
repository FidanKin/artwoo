<section id="signup-component" class="max-w-lg">
    <x-shared.core.simple-back path="/" />
    <x-shared.core.title text="{{ __('auth.signup_page_title') }}" containerClasses='mt-8 mb-9 text-center max-md:break-all' weight="bold" />
    <form action="/signup" method="POST" id="signup-form" />
        @csrf
        @if(session('form_save_error'))
            <div class="my-1">
                <span class="px-6 text-invalid-value text-base text-xs">
                    * {{ session('form_save_error') }}
                </span>
            </div>
        @endif
        <x-shared.form.textInput :elementData="$formData['login']" bgColor='sm-dark' />
        <x-shared.form.textInput :elementData="$formData['email']" bgColor='sm-dark' />
        <x-shared.form.passwordInput :elementData="$formData['password']" />
        <x-shared.form.checkbox :elementData="$formData['policyagreed']" bgwhite="{{ false }}"/>
        <x-shared.form.submit-input text="{{ __('auth.signup') }}" name='submit' includeMt={{ true }} />
    </form>
    <div class="mt-4">
        <span class="text-center inline-block w-full text-sm font-bold">
            {!!  __('auth.have_account_login') !!}
        </span>
    </div>
</section>
