import {firstCharacterUpperCase, isEmpty, isEmptyElementValue, rotateToggleIcon} from "./core.js";
import {isElement} from 'lodash';
import Datepicker from 'flowbite-datepicker/Datepicker';
import Tagify from '@yaireo/tagify';
import '@yaireo/tagify/dist/tagify.css';

const optionsDefault = {
    formElement: '.form-element', // общий класс для всех элементов формы
    formElementPlaceholder: '.form-control-label', // класс
    inputElement: 'div[data-area="form-element-wrapper"] input',
    textareaElement: 'div[data-area="form-element-wrapper"] textarea',
    isValidateForm: true, // меняем состояние инпутов при ошибке для улучшение UI
    customSelectors: {
        'inputSelect': '.select-menu',
    },
    autocomplete: {
        whitelist: ['name', 'age', 'surname', 'work', 'type'],
        maxTags: 10,
        dropdown: {
            maxItems: 3,           // <- mixumum allowed rendered suggestions
            classname: "tags-look", // <- custom classname for this dropdown, so it could be targeted
            enabled: 0,             // <- show suggestions on focus
            closeOnSelect: false
        }

    }
}

export function FormHandler(formId, options = {}) {
    const form = document.querySelector(`#${formId}`);
    if ( ! form) {
        return null;
    }

    const config = {...optionsDefault, ...options};

    this.form = form;
    this.formElements = config.formElement;
    this.labelClass = config.formElementPlaceholder;
    this.inputElement = config.inputElement;
    this.customSelectors = config.customSelectors;
    this.validateForm = config.isValidateForm;
    this.textareaElement = config.textareaElement;
    this.autocomplete = config.autocomplete;
    this.zIndex = 1000;
    this.placeholderTextColor = 'text-gray-600';

    this.formHandlers =  {
        formSelect(formElement) {
            this.selectInputInit(formElement);
        },
        formPassword(formElement) {
            const input = formElement.querySelector(this.inputElement);
            const passwordIcon = formElement.querySelector('.password-icon');
            const labelElement = formElement.querySelector(this.labelClass);
            this.labelHandler(formElement, input.value);
            input.addEventListener('input', (e) => {
                this.labelHandler(formElement, input.value);
                if (this.validateForm === true) {
                    deactivateInvalidState(input, [labelElement]);
                }

            })
            toggleDisplayPassword(input, passwordIcon);
        },
        formDefault(formElement) {
            const input = formElement.querySelector(this.inputElement);
            const labelElement = formElement.querySelector(this.labelClass);
            this.labelHandler(formElement, input.value);
            input.addEventListener('input', (e) => {
                this.labelHandler(formElement, input.value);
                if (this.validateForm === true) {
                    deactivateInvalidState(input, [labelElement]);
                }
            })
        },
        formDatepicker(formElement) {
            const input = formElement.querySelector(this.inputElement);
            const labelElement = formElement.querySelector(this.labelClass);
            let defaultValue = null;
            if (input.dataset.defaultValue) {
                defaultValue = input.dataset.defaultValue;
            }
            const datepicker = new Datepicker(input, {
                autohide: true,
                format: 'dd.mm.yyyy',
                autoclose: true,
                todayHighlight: true
            });
            datepicker.setDate(defaultValue);
            if (this.validateForm === true) {
                deactivateInvalidState(input, [labelElement]);
            }
            this.labelHandler(formElement, input.value);
        },

        formInlinedateinput(formElement) {
            // inlineDateInput(formElement.querySelector(this.inputElement));
        },

        formCheckbox() {

        },
        formTextarea(formElement) {
            const textareaElement = formElement.querySelector(this.textareaElement);
            //const label = textareaElement.dataset.label;
            //let labelActive = false;

            textareaElement.value = textareaElement.value.trim();

            // if (isEmpty(textareaElement.value)) {
            //     textareaElement.value = label;
            //     labelActive = true;
            // }
            // textareaElement.addEventListener('click', (e) => {
            //     if (labelActive) {
            //         labelActive = false;
            //         textareaElement.value = '';
            //     }
            // })
            // textareaElement.addEventListener('input', (e) => {
            //     if (isEmpty(textareaElement.value)) {
            //         textareaElement.value = label;
            //         labelActive = true;
            //     }
            // })
            // textareaElement.addEventListener('blur', (e) => {
            //     if (isEmpty(textareaElement.value)) {
            //         textareaElement.value = label;
            //         labelActive = true;
            //     }
            // })
        },
        formFile(formElement) {
            filesHandle(formElement, showfiles);
        },
        formAutocomplete(formElement) {
            const input = formElement.querySelector('input.autocomplete');
            const maxSelectedTag = this.autocomplete.maxTags;
            new Tagify(input, {
                maxTags: maxSelectedTag,
                dropdown: {
                    maxItems: 10,           // <- mixnum allowed rendered suggestions
                    enabled: 0,             // <- show suggestions on focus
                    closeOnSelect: false,
                    placeAbove: false
                },
                classNames: {
                    dropdown: 'border-none w-full block absolute pt-1',
                    dropdownWrapper: ' border-x-slate-100 border shadow w-full bg-white block rounded-xl px-6 py-3.5',
                    dropdownItem: 'inline-block mx-0.5 my-0.5 bg-black text-white px-2.5 py-1 text-xs rounded-tag cursor-pointer',
                    tagText: 'text-white px-1.5',
                }
            });
        }
    }
}

FormHandler.prototype.init = function() {
    const formControls = this.form.querySelectorAll(this.formElements);

    for (const formElement of formControls) {
        const type = formElement.dataset.formType;
        const fullNameType = 'form' + firstCharacterUpperCase(type);
        if (this.formHandlers.hasOwnProperty(fullNameType)) {
            const f = this.formHandlers[fullNameType].bind(this);
            f(formElement);
        } else {
            const f = this.formHandlers.formDefault.bind(this);
            f(formElement);
        }
    }
}

FormHandler.prototype.labelHandler = function(formControl, inputValue = '') {
    const activeClasses = ['scale-75', '-translate-y-4'];
    const label = formControl.querySelector(this.labelClass);

    if ( ! isEmptyElementValue(label) && ! isEmpty(inputValue)) {
        label.classList.add(...activeClasses);
        return true;
    }

    if ( ! isEmptyElementValue(label) && isEmpty(inputValue)) {
        label.classList.remove(...activeClasses);
        return true;
    }
}

FormHandler.prototype.selectInputInit = function(formElement) {
        formElement.style.zIndex = this.zIndex--;
        const selectMenu = formElement.querySelector(this.customSelectors.inputSelect);
        const selectMenuID = selectMenu.id;
        const optionsBlock = formElement.querySelector(`div[data-select-target=${selectMenuID}]`);
        const input = selectMenu.querySelector(this.inputElement);
        const titleElement = selectMenu.querySelector(this.labelClass);
        const iconElement = selectMenu.querySelector('div.select-icon img');

        if ( ! input.classList.contains('hidden') ) {
            return null;
        }

        if (optionsBlock == null) {
            return null;
        }

        const optionsList = optionsBlock.querySelectorAll('ul li');

        // скрываем раскрытый список, если кликнули не в менюшку
        document.addEventListener('click', (e) => {
            if ( ! selectMenu.contains(e.target) && ! optionsBlock.classList.contains('hidden') ) {
                selectToggleList(optionsBlock, selectMenu);
            }
        })

        if (optionsList.length > 0) {
            selectMenu.addEventListener('click', (e) => {
               //formElement.classList.toggle('z-50');
                selectToggleList(optionsBlock, selectMenu);
                rotateToggleIcon(iconElement);
                deactivateInvalidState(selectMenu, [titleElement]);
            })
        } else {
            // выпдающий список пуст ...
            selectMenu.classList.add('hidden');
        }

        for (let option of optionsList) {
            option.addEventListener('click', (e) => {
                const targetEl = e.target.closest('li');
                const visibleValue = targetEl.textContent.trim();
                const optionElementValue = targetEl.dataset.value;
                setSelectInputValue(input, optionElementValue, visibleValue, titleElement);
                selectToggleList(optionsBlock, selectMenu);
                rotateToggleIcon(iconElement);
            })
        }
}

/**
 * ===========================
 * Функции хелперы для формы (из вне не должны вызываеться!)
 * ===========================
 */

/**
 * Скрыть / показать пароль
 *
 * @param {Element} input - элемент формы пароля
 * @param {Element} actionTargetElement - при клике на элемент скрываем / показываем пароль
 */
function toggleDisplayPassword(input, actionTargetElement) {
    actionTargetElement.addEventListener('click', () => {
        input.classList.toggle('show-passowrd');
        if (input.classList.contains('show-passowrd')) {
            input.setAttribute('type', 'text');
        } else {
            input.setAttribute('type', 'password');
        }
    })
}

/**
 * Убираем состояние ошибки у элементов формы
 * @param {Element} targetElement - элемент, которому вешается признак ошибки
 * @param {array} dependentElemens -  элементы, которым нужно удалить состояние об ошибки
 *
 * @returns {void}
 */
function deactivateInvalidState(targetElement, dependentElemens) {
    const errorMarkClass = 'bg-inputInvalid';
    const errorClasses = [errorMarkClass, 'text-white'];
    const processElements = [targetElement, ...dependentElemens];

    if (targetElement.classList.contains(errorMarkClass)) {
        for (const n of processElements) {
            n.classList.remove(...errorClasses);
        }
    }
}

/**
 * При клике по селект меню нам меняем закругление у блока
 * и скрываем / показываем выпадающее меню
 *
 * @param {element} optionsBlock
 * @param {element} selectMenu
 */
function selectToggleList(actionElement, optionsWrapper) {
    actionElement.classList.toggle('hidden');
    optionsWrapper.classList.toggle('rounded-full');
    optionsWrapper.classList.toggle('rounded-t-3xl');
}

/**
 * В элемент менюшки устанавливаем значение, выбранное пользователем
 * В инпут записываем значение для бэка
 *
 * @param {HTMLElement} input
 * @param {string} value
 * @param {string} visibleValue
 * @param {element} titleElement
 */
function setSelectInputValue(input, value, visibleValue, titleElement) {
    titleElement.textContent = visibleValue;

    if (input.name === 'color') {
        titleElement.innerHTML = `<div class="flex flex-row justify-center content-center">
            <span class="custom-select-color ${value}"></span><span class="ml-1.5 leading-loose">${visibleValue}</span>
        </div>`;
    }

    titleElement.classList.remove('text-gray-600');
    titleElement.classList.add('text-black');
    input.setAttribute('value', value);
    input.dispatchEvent(new InputEvent("input")); // fire event for other elements
}

/**
 * Получаем файлики, записываем их в массив объектов и полученный файлик передаем в колбек
 *
 * @param {Element} element
 * @param {Function} callback
 */
function filesHandle(formElement, callback) {
    const input = formElement.querySelector('input.filepicker-simple');

    if ( ! isElement(input) ) {
        console.warn('incorrect element for fileInput');
        return false;
    }

    input.addEventListener("change", function(e) {
        if (this.files === false) {
            return false;
        }
        let allfiles = [];
        const fs = this.files;
        for(const file of fs) {
            if ( ! file.type.startsWith("image/") ) {
                continue;
            }
            allfiles.push(file);
        }

        if (callback !== false && typeof callback === 'function') {
            callback(allfiles, formElement);
        }
    });
}

/**
 * Отобразить загруженные пользователем файлы
 *
 * @param {Array} files - массив с файлами
 */
function showfiles(files, context) {
    for (const file of files) {
        insertFileToForm(file, context);
    }
}

function insertFileToForm(file, context) {
    const fileContainer = context.querySelector('.file_upload_area .files_show');
    const template = (url) => {
        return `<div class="file-upload-container w-[100px] max-w-[102px] h-auto overflow-hidden rounded
                relative inline-block p-2 border border-md-gray border-solid flex flex-row items-center justify-center">
                    <div class="h-full">
                        <div class="upload-item-file static block leading-none max-h-full relative m-auto object-contain
                        overflow-hidden flex-none group">
                            <button type="button" class="float-right bg-white rounded-md p-1 inline-flex items-center justify-center
                                text-gray-500 hover:bg-gray-200 focus:outline-none mb-2" data-action-code="delete">
                                <span class="sr-only">Close menu</span>
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <img src='${url}' data-image-blob="1" class='block static object-contain overflow-hidden max-w-[86px] max-h-[86px] ' />
                    </div>
                    </div>
                </div>`
    }
    let bloburl = URL.createObjectURL(file);

    fileContainer.insertAdjacentHTML('afterbegin', template(bloburl));
    setTimeout(() => {
        URL.revokeObjectURL(bloburl);
    }, 10)
}

export function handleRemoveImage(apiInstance = null) {
    const imageContainer = document.querySelector("form .form-element[data-form-type='file']");
    try {
        const collectionContainer = imageContainer.querySelectorAll('.files_show .file-upload-container');
        collectionContainer.forEach((element, index) => {
            handleDeleteAction(element, apiInstance);
        });
    } catch (err) {
        return false;
    }
}

function handleDeleteAction(element, apiInstance) {
    const actionElement = findDeleteImageButton(element);
    if (actionElement === null) {
        console.log('cannot execute remove action');
        return;
    }
    actionElement.addEventListener('click', async (clickEvent) => {
        await removeImage(element, apiInstance);
    })
}

/**
 * Находим кнопку, которая является действием для совершения запроса на удаление
 *
 * @param imageElement - контнейнер (врапер) изображения
 * @returns {Element|SVGSymbolElement|SVGMetadataElement|SVGUseElement|SVGAnimateElement|SVGFEImageElement|SVGPathElement|SVGViewElement|SVGFEConvolveMatrixElement|SVGFECompositeElement|SVGEllipseElement|SVGFEOffsetElement|SVGTextElement|SVGDefsElement|SVGFETurbulenceElement|SVGImageElement|SVGFEFuncGElement|SVGMPathElement|SVGTSpanElement|SVGClipPathElement|SVGLinearGradientElement|SVGFEFuncRElement|SVGScriptElement|SVGFEColorMatrixElement|SVGFEComponentTransferElement|SVGStopElement|SVGMarkerElement|SVGFEMorphologyElement|SVGFEMergeElement|SVGFEPointLightElement|SVGForeignObjectElement|SVGFEDiffuseLightingElement|SVGStyleElement|SVGFEBlendElement|SVGCircleElement|SVGPolylineElement|SVGDescElement|SVGFESpecularLightingElement|SVGLineElement|SVGFESpotLightElement|SVGFETileElement|SVGPatternElement|SVGTitleElement|SVGSwitchElement|SVGRectElement|SVGFEDisplacementMapElement|SVGFEFuncAElement|SVGFEFuncBElement|SVGFEMergeNodeElement|SVGTextPathElement|SVGFEFloodElement|SVGMaskElement|SVGAElement|SVGAnimateTransformElement|SVGSetElement|SVGSVGElement|SVGAnimateMotionElement|SVGGElement|SVGFEDistantLightElement|SVGFEDropShadowElement|SVGRadialGradientElement|SVGFilterElement|SVGPolygonElement|SVGFEGaussianBlurElement|HTMLSelectElement|HTMLLegendElement|HTMLElement|HTMLTableCaptionElement|HTMLTextAreaElement|HTMLModElement|HTMLHRElement|HTMLOutputElement|HTMLEmbedElement|HTMLCanvasElement|HTMLScriptElement|HTMLInputElement|HTMLMetaElement|HTMLStyleElement|HTMLObjectElement|HTMLTemplateElement|HTMLBRElement|HTMLAudioElement|HTMLIFrameElement|HTMLMapElement|HTMLTableElement|HTMLAnchorElement|HTMLMenuElement|HTMLPictureElement|HTMLParagraphElement|HTMLTableCellElement|HTMLTableSectionElement|HTMLQuoteElement|HTMLProgressElement|HTMLLIElement|HTMLTableRowElement|HTMLSpanElement|HTMLTableColElement|HTMLOptGroupElement|HTMLDataElement|HTMLDListElement|HTMLFieldSetElement|HTMLSourceElement|HTMLBodyElement|HTMLDivElement|HTMLUListElement|HTMLDetailsElement|HTMLHtmlElement|HTMLAreaElement|HTMLPreElement|HTMLMeterElement|HTMLOptionElement|HTMLImageElement|HTMLLinkElement|HTMLHeadingElement|HTMLSlotElement|HTMLVideoElement|HTMLTitleElement|HTMLButtonElement|HTMLHeadElement|HTMLDialogElement|HTMLTrackElement|HTMLOListElement|HTMLDataListElement|HTMLLabelElement|HTMLFormElement|HTMLTimeElement|HTMLBaseElement|null}
 */
function findDeleteImageButton(imageElement) {
    const actionButtonSelector = ".upload-item-file button[data-action-code='delete']";
    try {
        return imageElement.querySelector(actionButtonSelector);
    } catch (err) {
        console.warn('action button for delete image not found!');
        return null;
    }
    return null;
}

async function removeImage(element, apiInstance) {
    const imgElement = element.querySelector('.upload-item-file > img');
    if (imgElement) {
        if (isBlobImage(imgElement)) {
            element.remove();
            return true;
        } else {
            if (! apiInstance) {
                console.log("For delete image need api instance");
                return false;
            }
            const imgpathhash = getImagePathnamehash(imgElement);
            const result = await apiInstance.deleteFile('/artwork/files', {action_token: getFormKey(),
                pathnamehash: imgpathhash});
            if (result.success) {
                element.remove();
                return true;
            } else {
                console.log('cannot delete');
            }
        }
    }

    return false;
}

function getImagePathnamehash(imgElement) {
    const src = new URL(imgElement.src);
    return src.pathname.split('/').pop();
}

function isBlobImage(imgElement) {
    return imgElement.dataset.imageBlob === "1";
}
