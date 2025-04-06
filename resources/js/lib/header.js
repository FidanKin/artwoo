const header = document.querySelector("header#header");

function editArtworkLink(headerElement) {
    if (headerElement == null) {
        return;
    }

    let link = headerElement.querySelector("a#header-artwork-edit-link.interactive-link");
    if (! link) {
        return null;
    }

    const linkImg = link.querySelector("img");
    const clickImg = '/icons/header/artwork-after.png';

    const to = link.href;
    link.href = '#';

    link.addEventListener("click", () => {
        linkImg.src = clickImg;
        setTimeout(() => document.location.href = to, 600);
    });
}

editArtworkLink(header);
