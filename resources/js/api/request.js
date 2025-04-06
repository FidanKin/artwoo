import axios from "axios";
import { trim } from 'lodash';

export function apiRequest(configParams = {}) {
    const defaultConfig = {contentType: 'application/json', withApiKey: true};
    const config = {...defaultConfig, ...configParams};
    this.api_key = window.api_key;
    this.axios = axios;
    this.contentType = config.contentType;
    this.api_path = '/api/';
    this.baseUrl = window.location.origin + this.api_path;
    this.apiParam = {};
    if (config.withApiKey) {
        this.apiParam = {api_key: this.api_key};
    }
    this.url = {};
}

apiRequest.prototype.buildUrl = function(path, params = {}) {
    const url = new URL(this.baseUrl + trim(path, '/') + '/');
    const p = new URLSearchParams({...params, ...this.apiParam});
    url.search = p.toString();
    return url.toString();

}

apiRequest.prototype.deleteFile = function(path, queryParams = {}) {
    return this.axios.delete(this.buildUrl(path, queryParams),
        {
            headers: {
                'content-type': 'application/json',
            },
            data: {}
        }
        )
        .then(function(response){
            return response.data;
        })
        .catch(function(error) {
            return error.response.data;
        })
}

/**
 * Выполнить GET запрос
 *
 * @param path - путь
 * @param queryParams - параметры запроса
 * @returns {Promise<axios.AxiosResponse<any> | T | T>}
 */
apiRequest.prototype.get = function(path, queryParams = {}) {
    return this.axios.get(this.buildUrl(path, queryParams))
        .then(function(response){
            return response.data;
        })
        .catch(function(error) {
            return error.response.data;
        })
}

/**
 * Выполинть DELETE запрос
 *
 * @param path - путь
 * @param queryParams - параметры запроса
 * @returns {Promise<axios.AxiosResponse<any> | T | T>}
 */
apiRequest.prototype.delete = function(path, queryParams = {}) {
    // https://stackoverflow.com/questions/73765226/how-to-add-javascript-object-as-a-urls-searchparams-without-looping
    return this.axios.delete(this.buildUrl(path, queryParams),
        {
            headers: {
                'content-type': 'application/json'
            }
        })
        .then(function(response) {
            return response.data;
        })
}




