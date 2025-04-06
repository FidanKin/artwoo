
export function closeElements(contextElement = null, callback = null) {
    let element = contextElement;
    if (element === null) element = document;
    const buttons = element.querySelectorAll("button[data-dismiss-target]");
    if ((buttons instanceof NodeList) && buttons.length > 0) {
        buttons.forEach((button) => {
            button.addEventListener("click", () => {
                const el = document.querySelector(button.dataset.dismissTarget);
                if (el) {
                    el.remove();

                    if (callback && typeof callback === 'function') {
                        callback();
                    }
                }
            })
        })
    }
}
