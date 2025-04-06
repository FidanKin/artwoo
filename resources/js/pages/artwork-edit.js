import { FormHandler } from "../lib/form.js";
import '@yaireo/tagify/dist/tagify.css';
import { MultiselectDropdown } from "@/lib/form_element_multiselect.js";
import {apiRequest} from "@/api/request.js";
import {isEmpty} from "../lib/core.js";

(() => {
    MultiselectDropdown();
    let f = new FormHandler('edit-artwork');
    f.init();
    getFormKey('edit-artwork');
    const filesContainer = document.querySelector(".file_upload_area .files_show");
    const form = getForm();
    handleComponentArtworks(!isEmpty(form.get('item_id')));
})();

const api = new apiRequest();
const imageContainer = document.querySelector('.files_show');
imageContainer.addEventListener('DOMNodeInserted', (event) => {
   deleteImage();
}, false);

deleteImage();

/**
 * Инициализация возможности удаления загруженных файлов по API
 *
 * @returns {boolean}
 */
function deleteImage() {
    const imageContainer = document.querySelector("#edit-artwork .form-element[data-form-type='file']");
    try {
        const collectionContainer = imageContainer.querySelectorAll('.files_show .file-upload-container');
        collectionContainer.forEach((element, index) => {
            handleDeleteAction(element, api);
        });
    } catch (err) {
        return false;
    }
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

function isBlobImage(imgElement) {
    return imgElement.dataset.imageBlob === "1";
}

function getImagePathnamehash(imgElement) {
    const src = new URL(imgElement.src);
    return src.pathname.split('/').pop();
}

async function removeImage(element, apiInstance = null) {
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
            const result = await apiInstance.deleteFile('/artwork/files', {
                pathnamehash: imgpathhash,
                source_id: getForm().get('item_id')
            });

            console.log(result);

            if (result.success) {
                element.remove();
                return true;
            } else {
                console.log('>>> invalid request');
            }
        }
    }

    return false;
}

function getFormKey() {
    const current = document.getElementById('edit-artwork');
    const formData = new FormData(current);
    return formData.get('formkey');
}

function getForm() {
    const current = document.getElementById('edit-artwork');
    return new FormData(current);
}

function handleComponentArtworks(isExistEntity) {
    const stateCheckbox = document.querySelector("form#edit-artwork [data-input='has_components'] input");
    const quantitySelect = document.querySelector("form#edit-artwork [data-input='number_components']");
    const quantitySelectInput = quantitySelect.querySelector('input');
    const sizeElement = document.querySelector("form#edit-artwork [data-input='size']");
    const sizeBlock = document.querySelector("form#edit-artwork [data-input='component_sizes']");
    let sizeElementClone = null;
    let checkboxState = stateCheckbox.checked;

    if (sizeBlock) {
        sizeElementClone = sizeElement.cloneNode(true);
    }

    if (stateCheckbox.checked) {
        quantitySelect.classList.remove('hidden');
    }

    stateCheckbox.addEventListener('change', (event) => {
        if (event.currentTarget.checked) {
            checkboxState = 1;
            quantitySelect.classList.remove('hidden');
            sizeElementAction(sizeElement);
            selectResetState(quantitySelect);
        } else {
            sizeElementAction(sizeElement, true);
            quantitySelect.classList.add('hidden');
            selectResetState(quantitySelect);
            sizeBlock.innerHTML = '';
        }
    })

    quantitySelectInput.addEventListener('input', (selectEvent) => {
        let checkboxState = stateCheckbox.checked;

        if (checkboxState) {
            quantitySelectAction(selectEvent.currentTarget.value, sizeBlock, sizeElement, sizeElementClone);
        }
    })

    stateCheckbox.addEventListener('change', (event) => {
        if (event.currentTarget.checked) {
            // quantitySelect.classList.remove('hidden');
            quantitySelectInput.addEventListener('input', (selectEvent) => {
                // quantitySelectAction(selectEvent.currentTarget.value, sizeBlock, sizeElement, sizeElementClone)
            //     sizeBlock.innerHTML = '';
            //     sizeBlock.classList.remove('hidden');
            //
            //     applyDefaultValueSizeElement(sizeElementClone);
            //     sizeBlock.append(sizeElementClone);
            //     for (let i = 1; i < selectEvent.currentTarget.value; i++) {
            //         let el = sizeElementClone.cloneNode(true);
            //         applyDefaultValueSizeElement(sizeElementClone);
            //         sizeBlock.append(el);
            //     }
            //
            //     sizeElementAction(sizeElement);
            })
        } else {
            // sizeBlock.classList.add('hidden');
            // sizeElementAction(sizeElement, true);
            // selectResetState(quantitySelect);
        }
    })
}

function applyDefaultValueSizeElement(sizeElement) {
    sizeElement.classList.remove('hidden');
    const inputs = sizeElement.querySelectorAll("input[name]");
    inputs.forEach((input) => {
        input.value = '';
        input.disabled = false;
    });
}

/**
 *
 * @param sizeBlock
 * @param activate
 * @return void
 */
function sizeElementAction(sizeBlock, activate = false) {
    if (sizeBlock) {
        activate ? sizeBlock.classList.remove('hidden') : sizeBlock.classList.add('hidden');

        /** @var array inputs */
        const inputs = sizeBlock.querySelectorAll("input");
        inputs.forEach(input => {
            input.disabled = !activate;
        })
    }
}

/**
 *
 * @param selectElement
 * @return void
 */
function selectResetState(selectElement) {
    const input = selectElement.querySelector("input");
    const textElement = selectElement.querySelector("span.form-control-label");
    const placeholder = textElement.dataset.text;

    input.setAttribute('value', '');
    textElement.textContent = placeholder;
}

function quantitySelectAction(countElements, sizeBlock, sizeElement, sizeElementClone) {
    sizeBlock.innerHTML = '';
    sizeBlock.classList.remove('hidden');

    applyDefaultValueSizeElement(sizeElementClone);
    sizeBlock.append(sizeElementClone);

    for (let i = 1; i < countElements; i++) {
        let el = sizeElementClone.cloneNode(true);
        applyDefaultValueSizeElement(sizeElementClone);
        sizeBlock.append(el);
    }

    sizeElementAction(sizeElement);
}
