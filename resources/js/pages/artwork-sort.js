import Sortable from "sortablejs";

(() => {
    const form = document.forms['sortable'];
    const bSubmit = form.querySelector('#submit-button input');
    const artworkImagesEl = document.querySelector('#artwork-images');
    const iSort = form.querySelector('#sort-input');
    let prevent = true;

    new Sortable(artworkImagesEl, {
        animation: 200,
    });

    bSubmit.addEventListener('click', (event) => {
        if (prevent === true) {
            event.preventDefault();
            iSort.value = JSON.stringify(getPositionsJson(artworkImagesEl));
            prevent = false;
        }

        bSubmit.click();
    });
})();

function getPositionsJson(element) {
    const p = {};
    let collections = [];

    element.querySelectorAll('a.artwork-image-full').forEach(linkEl => {
        const pLength = collections.length;
        const ID = getImageIdByPath(linkEl.href);

        if (ID) {
            collections.push({[ID]: pLength});
        }
    });

    return collections;
}

function getImageIdByPath(url) {
    const parsed = URL.parse(url);

    if (parsed === null) {
        return parsed;
    }

    const arrLinkPath = parsed.pathname.split('/');

    if (arrLinkPath) {
        return arrLinkPath.pop();
    }

    return null;
}