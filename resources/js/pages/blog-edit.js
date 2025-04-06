import { FormHandler } from "../lib/form.js";
import Tagify from '@yaireo/tagify';
import '@yaireo/tagify/dist/tagify.css';

let f = new FormHandler('edit-blog');
f.init();

const tag = document.querySelector('form#edit-blog #input-tags');
new Tagify(tag);
