// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
// OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
// SOFTWARE.
import tippy from "tippy.js";
import 'tippy.js/dist/tippy.css';

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
