@stack("main_front")
<script>
    (function () {
        // закрыть флуш сообщение
        let element = document;
        const buttons = element.querySelectorAll("button[data-dismiss-target]");
        if ((buttons instanceof NodeList) && buttons.length > 0) {
            buttons.forEach((button) => {
                button.addEventListener("click", () => {
                    const el = document.querySelector(button.dataset.dismissTarget);
                    if (el) el.remove();
                })
            })
        }
    })()
</script>