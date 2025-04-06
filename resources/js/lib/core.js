import "./close_action.js"
import {closeElements} from "./close_action.js";
export function isDomElement(element) {
    return element instanceof Element || element instanceof HTMLElement;
}

export function isEmptyElementValue(element) {
    if (!isDomElement(element)) return true;
    if (isEmpty(element.value)) return true;
    return false;
}

export function isEmpty(value) {
    if (value == null) return false;
    const res = value.trim();
    return res === '' || res === undefined;
}

export function firstCharacterUpperCase(text) {
    return text.charAt(0).toUpperCase()
        + text.substring(1).toLowerCase()
}

export function rotateToggleIcon(iconElement) {
    iconElement.classList.toggle('rotate-180')
}

export function cookie_notification() {
    const cookies = getCookie();

    if (! cookies.hasOwnProperty('accept_cookie') || (cookies.hasOwnProperty('accept_cookie')
        && cookies.accept_cookie !== 'true')) {
        document.body.insertAdjacentHTML('afterbegin', cookie_modal_template());
        document.addEventListener('DOMContentLoaded', function() {
            closeElements(document.querySelector(".cookie__notification-modal"), function() {
                document.cookie = 'accept_cookie=true;samesite=strict;max-age=31622400';
            });
        });
    }
}

function cookie_modal_template() {
    return `<div class="cookie__notification-modal min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12 absolute top-0">
            <div class="max-w-screen-lg mx-auto fixed bg-white inset-x-5 p-5 bottom-2 rounded-lg drop-shadow-2xl flex gap-4 flex-wrap md:flex-nowrap text-center md:text-left items-center justify-center md:justify-between">
                <div class="w-full">Используя данный сайт, вы даете согласие на использование файлов cookie, помогающих нам
                    сделать его удобнее для вас.
                    <a href="/pages/privacy-cookie" class="text-primaryColor whitespace-nowrap  hover:underline">Подробнее</a>
                </div>
                <div class="flex gap-4 items-center flex-shrink-0">
                    <button class="bg-primaryColor px-5 py-2 text-white rounded-md hover:bg-indigo-700 focus:outline-none"
                        data-dismiss-target=".cookie__notification-modal">
                        Принять
                    </button>
                </div>
            </div>
        </div>`
}

function getCookie() {
    return document.cookie.split('; ').reduce((acc, item) => {
        const [name, value] = item.split('=')
        acc[name] = value
        return acc
    }, {})
}
