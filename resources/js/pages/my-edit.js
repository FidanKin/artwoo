// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
// OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
// SOFTWARE.
import { FormHandler } from "../lib/form.js";
import tippy from "tippy.js";
import 'tippy.js/dist/tippy.css';
import axios from "axios";

const collectionArtworkDescription = document.querySelectorAll(".artwork-collection .artwork-item " +
    ".artwork-item__description");
collectionArtworkDescription.forEach((element) => {
    let priceElement = element.querySelector(".artwork_item__cost");
    if (priceElement) {
        let price = priceElement.dataset.cost;
        tippy(priceElement, {
            content: price + " руб."
        })
    }
})

let f = new FormHandler('profile-form');
f.init();

const profileForm= document.querySelector("#profile-form");

if (profileForm) {
    const imageContainer = document.querySelector('.files_show');
    let observe = new MutationObserver(async (changes) => {
        let userPicture = profileForm.querySelector(".form-element .upload-item-file img.block.static.object-contain");
        if (userPicture) {
            await deleteImageHandler(profileForm, userPicture);
        }
    });
    observe.observe(imageContainer, {
        childList: true,
        characterDataOldValue: true
    });

    let userPicture = profileForm.querySelector(".form-element .upload-item-file img.block.static.object-contain");
    if (userPicture) {
        await deleteImageHandler(profileForm, userPicture);
    }
}

async function deleteImageHandler(formElement, image) {
    const formData = new FormData(formElement);
    const deleteAction = find_delete_image_button(formElement.querySelector('.file-upload-container'));

    if (deleteAction) {
        deleteAction.addEventListener('click', async () => {
            if (is_blob_image(image)) {
                return remove_image(image);
            } else {
                const imageUrl = new URL(image.src).pathname;
                const imageID = imageUrl.split('/').pop();
                const result = await axios({
                    method: 'delete',
                    url: '/api/user/files?api_key=' + window.api_key,
                    data: {
                        source_id: formData.get('user_id'),
                        pathhash: imageID
                    }
                });

                if (result.status === 200) {
                    remove_image(image);
                }

            }
        })
    }
}

function find_delete_image_button (imageContainer) {
    const actionButtonSelector = ".upload-item-file button[data-action-code='delete']";
    try {
        return imageContainer.querySelector(actionButtonSelector);
    } catch (err) {
        console.warn('action button for delete image not found!');
        return null;
    }
}

function remove_image(image) {
    const container = image.closest('.files_show .file-upload-container');
    if (container) {
        container.remove();
        return true;
    }

    return false;
}

function is_blob_image(imgElement) {
    return imgElement.dataset.imageBlob === "1";
}


