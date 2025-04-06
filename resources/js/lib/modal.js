import MicroModal from 'micromodal';

const triggeredElements = document.querySelectorAll('.modal-trigger-element');
const modals = document.querySelectorAll(".modal.modal-slide");

if (modals) {
    const root = document.body;
    modals.forEach(modal => {
        // root.appendChild(modal);
        // let jsonAction = modal.querySelector(".form-action-data").dataset.actionValue;
        // if (jsonAction === undefined || jsonAction === false || jsonAction === '') {
        //     return;
        // }

        // @todo создать рендер формы, который будет устанавливаться в модалку для действия
        // или же рассмотреть стак и пуш
    })
}

if (triggeredElements) {
    triggeredElements.forEach(element => {
        element.addEventListener('click', (event) => {
            event.preventDefault();
        });
    })
}

MicroModal.init();

