import axios from 'axios';
import "./lib/modal.js";
import "./lib/header.js";
import "./lib/core.js";
import {cookie_notification} from "./lib/core.js";

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.url = 'http://127.0.0.1:8000/api/';

(function() {
    window.api_key = import.meta.env.VITE_APP_API_KEY ?? '';
    cookie_notification();
})();
