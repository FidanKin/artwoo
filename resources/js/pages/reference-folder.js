import { FormHandler } from "../lib/form.js";
import { references_add_action} from "@/lib/references.js";
import {handleRemoveImage} from "../lib/form.js";
import venoBox from "venobox";
import 'venobox/src/venobox.css';

(() => {
    const fh = new FormHandler("add-references");
    fh.init();

    const imageContainer = document.querySelector('.files_show');
    handleRemoveImage();
    imageContainer.addEventListener('DOMNodeInserted', (event) => {
        handleRemoveImage();
    }, false);
    references_add_action();

    new venoBox({
        selector: '.reference-image-preview',
        infinigall: true,
        shard: false,
        maxWidth: '850px',
    });
})();
