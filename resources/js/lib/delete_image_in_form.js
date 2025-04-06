
export function handle_delete_image_in_form(formID, apiInstance = null, apiDeletePath = null) {
    this.form_id = formID;
    this.container = document.querySelector(`#${formID} .form-element[data-form-type='file']`);
    this.api_instance = apiInstance;
    this.api_delete_path = apiDeletePath;
}

handle_delete_image_in_form.prototype.handle_delete_action = function() {
    try {
        const images = this.container.querySelectorAll('.files_show .file-upload-container');
        images.forEach((element, index) => {
            const actionElement = find_delete_image_button(element);
            if (actionElement === null) {
                console.log('cannot execute remove action');
                return;
            }
            actionElement.addEventListener('click', async (clickEvent) => {
                await this.remove_image(element);
            })
        });
    } catch (err) {
        console.log(err);
        return false;
    }
}

/**
 * Находим кнопку, которая является действием для совершения запроса на удаление
 *
 * @param imageElement - контнейнер (врапер) изображения
 * @returns {Element|SVGSymbolElement|SVGMetadataElement|SVGUseElement|SVGAnimateElement|SVGFEImageElement|SVGPathElement|SVGViewElement|SVGFEConvolveMatrixElement|SVGFECompositeElement|SVGEllipseElement|SVGFEOffsetElement|SVGTextElement|SVGDefsElement|SVGFETurbulenceElement|SVGImageElement|SVGFEFuncGElement|SVGMPathElement|SVGTSpanElement|SVGClipPathElement|SVGLinearGradientElement|SVGFEFuncRElement|SVGScriptElement|SVGFEColorMatrixElement|SVGFEComponentTransferElement|SVGStopElement|SVGMarkerElement|SVGFEMorphologyElement|SVGFEMergeElement|SVGFEPointLightElement|SVGForeignObjectElement|SVGFEDiffuseLightingElement|SVGStyleElement|SVGFEBlendElement|SVGCircleElement|SVGPolylineElement|SVGDescElement|SVGFESpecularLightingElement|SVGLineElement|SVGFESpotLightElement|SVGFETileElement|SVGPatternElement|SVGTitleElement|SVGSwitchElement|SVGRectElement|SVGFEDisplacementMapElement|SVGFEFuncAElement|SVGFEFuncBElement|SVGFEMergeNodeElement|SVGTextPathElement|SVGFEFloodElement|SVGMaskElement|SVGAElement|SVGAnimateTransformElement|SVGSetElement|SVGSVGElement|SVGAnimateMotionElement|SVGGElement|SVGFEDistantLightElement|SVGFEDropShadowElement|SVGRadialGradientElement|SVGFilterElement|SVGPolygonElement|SVGFEGaussianBlurElement|HTMLSelectElement|HTMLLegendElement|HTMLElement|HTMLTableCaptionElement|HTMLTextAreaElement|HTMLModElement|HTMLHRElement|HTMLOutputElement|HTMLEmbedElement|HTMLCanvasElement|HTMLScriptElement|HTMLInputElement|HTMLMetaElement|HTMLStyleElement|HTMLObjectElement|HTMLTemplateElement|HTMLBRElement|HTMLAudioElement|HTMLIFrameElement|HTMLMapElement|HTMLTableElement|HTMLAnchorElement|HTMLMenuElement|HTMLPictureElement|HTMLParagraphElement|HTMLTableCellElement|HTMLTableSectionElement|HTMLQuoteElement|HTMLProgressElement|HTMLLIElement|HTMLTableRowElement|HTMLSpanElement|HTMLTableColElement|HTMLOptGroupElement|HTMLDataElement|HTMLDListElement|HTMLFieldSetElement|HTMLSourceElement|HTMLBodyElement|HTMLDivElement|HTMLUListElement|HTMLDetailsElement|HTMLHtmlElement|HTMLAreaElement|HTMLPreElement|HTMLMeterElement|HTMLOptionElement|HTMLImageElement|HTMLLinkElement|HTMLHeadingElement|HTMLSlotElement|HTMLVideoElement|HTMLTitleElement|HTMLButtonElement|HTMLHeadElement|HTMLDialogElement|HTMLTrackElement|HTMLOListElement|HTMLDataListElement|HTMLLabelElement|HTMLFormElement|HTMLTimeElement|HTMLBaseElement|null}
 */
function find_delete_image_button (imageElement) {
    const actionButtonSelector = ".upload-item-file div[data-action-code='delete']";
    try {
        return imageElement.querySelector(actionButtonSelector);
    } catch (err) {
        console.warn('action button for delete image not found!');
        return null;
    }
}

handle_delete_image_in_form.prototype.remove_image = async function(element) {
    const imgElement = element.querySelector(".upload-item-file > img");
    if (imgElement) {
        if (is_blob_image(imgElement)) {
            element.remove();
            return true;
        } else {
            if (! this.api_instance || ! this.api_delete_path) {
                console.log("For delete image need <api instance> and <api delete path>");
                return false;
            }
            const imgpathhash = get_image_pathnamehash(imgElement);
            const result = await this.api_instance.deleteFile(this.api_delete_path, {
                action_token: getFormKey(this.form_id),
                pathnamehash: imgpathhash
            });
            if (result.success) {
                element.remove();
                return true;
            } else {
                console.log("cannot delete :(");
            }
        }
    }

    return false;
}

/**
 * Проверяем, что изображение отрисовали браузером
 *
 * @param imgElement
 * @returns {boolean}
 */
function is_blob_image(imgElement) {
    return imgElement.dataset.imageBlob === "1";
}

/**
 * Pathname берется из конца пути
 *
 * @param imgElement
 * @returns {string}
 */
function get_image_pathnamehash(imgElement) {
    const src = new URL(imgElement.src);
    return src.pathname.split('/').pop();
}

function getFormKey(formID) {
    const current = document.getElementById(formID);
    const formData = new FormData(current);
    return formData.get('formkey');
}