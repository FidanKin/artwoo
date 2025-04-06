import { FormHandler } from "../lib/form.js";
import { references_add_action} from "@/lib/references.js";

let f = new FormHandler('create-folder');
f.init();

references_add_action();
