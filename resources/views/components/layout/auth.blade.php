<div id="content-container">
    <div id="content-inner" class="grid md:grid-cols-2">
        <section id="page-content" class="p-12 max-md:p-6">
            <div id="logo-header" class="pt-1 pb-1">
                <a href="/">
                    <x-shared.core.logo />
                </a>
            </div>
            {{ $slot }}
        </section>
        <section id="auth-image" class="max-md:hidden bg-[url('/images/signup-bg.jpg')] bg-cover"></section>
    </div>
</div>
