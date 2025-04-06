import { FormHandler } from "../lib/form.js";

let f = new FormHandler('send-message');
f.init();

window.addEventListener("load", (e) => {
    (function() {
        const toScroll = document.querySelector("section#single-chat .message-wrapper");
        toScroll.scrollTop = toScroll.scrollHeight;
    })();
})
