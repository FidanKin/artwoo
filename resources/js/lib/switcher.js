const switcher = document.querySelector(".switch-element .switch #switcher");

if (switcher) {
    switcher.addEventListener('click', function(event) {
        setTimeout(() => {
            console.log(switcher.checked);
            window.location.href = getData(switcher);
        }, 500)

    });
}

function getData(switcher) {
    if (! switcher) {
        return null;
    }

    let data = null;

    if (switcher.checked) {
        data = switcher.dataset.actionOn;
    } else {
        data = switcher.dataset.actionOff;
    }

    return data;
}
