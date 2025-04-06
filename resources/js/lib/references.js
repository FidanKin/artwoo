import tippy from "tippy.js";

/**
 * Добавить действия для рефов
 * html действия берется из template
 */
export function references_add_action() {
    const references = document.querySelectorAll(".reference-collection .reference-item");

    if (references) {
        references.forEach((noused) => {
            tippy(".reference-item-actions", {
                content(reference) {
                    const template = reference.querySelector(".tooltip-template");
                    return template.innerHTML;
                },
                allowHTML: true,
                placement: 'bottom',
                trigger: 'click',
                hideOnClick: 'toggle',
                appendTo: document.body,
                interactive: true
            })
        })
    }
}