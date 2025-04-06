import { isElement } from "lodash";
import {apiRequest} from "@/api/request.js";

export function apiAction(callback, method = 'get', container = null) {
    if (!isElement(container)) container = document;
    const actions = container.querySelectorAll("button[data-action-method][data-action-request]");
    if (actions.length > 0) {
        const api = new apiRequest();
        actions.forEach((actionButton) => {
            const [method, request] = [actionButton.dataset.actionMethod, actionButton.dataset.actionRequest];
            const {params, path} = explodeRelativeRequest(request);
            actionButton.addEventListener("click", async (event) => {
                if (method === 'delete') {
                    const result = await api.delete(path, params);
                    return callback({event: event, method: method, path: path, data: result});
                }
            })
        })
    }
}

/**
 * Разбивает относительную строку запроса на объект со свойствами: параметры (объект) и путь (строка)
 *
 * @param relativeRequest - относительная строка запроса
 * @returns {{path: string, params: {[p: string]: string}}}
 */
function explodeRelativeRequest(relativeRequest) {
    // https://stackoverflow.com/questions/8648892/how-to-convert-url-parameters-to-a-javascript-object
    const url = new URL(relativeRequest, new URL(window.location.origin));
    return {params: Object.fromEntries(new URLSearchParams(url.searchParams)), path: url.pathname};
}
