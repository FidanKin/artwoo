import { FormHandler } from "../lib/form.js";
import '@yaireo/tagify/dist/tagify.css';
import {closeElements} from "@/lib/close_action.js";
import {apiAction} from "@/api/api_action.js";
import {isElement} from "lodash";

const autocompleteConfig = {autocomplete: {maxTags: 6}}; // изучить глубокое копирование объектов js
const resumeAdd = new FormHandler('resume-add-workplace');
const resumeEdit = new FormHandler('edit-resume', autocompleteConfig);
resumeAdd.init();
resumeEdit.init();

apiAction((result) => {
    const {event, method, path, data} = result;
    if (data.success === true && method === 'delete' && path === "/resume/workplace") {
        if (isElement(event.target)) {
            const item = event.target.closest("article.resume-item");
            if (isElement(item)) item.remove();
        }
    }
}, 'delete');

document.addEventListener("DOMContentLoaded", function (event) {
   closeElements();
});

function Resume() {
    this.resumeContainer = document.querySelector("#resume");
    this.existingWorkplacesContainer = this.resumeContainer.querySelector("#resume-organizations");
    this.addWorkplaceButton = document.querySelector("header button#add-workplace");
    this.workplaceForm = this.resumeContainer.querySelector("#resume-add-workplace");
}

Resume.prototype.updateState = function() {
    if (!this.hasWorkplaces()) {
        this.showWorkplaceForm();
    }

    if (!this.addWorkplaceButton) {
        this.hideWorkplaceForm();
        return;
    }

    if (this.isWorkplaceFormActive()) {
        this.disableAddWorkplaceButton();
    }

    if (!this.addWorkplaceButton.classList.contains('disable') &&
        !this.addWorkplaceButton.hasAttribute('disabled'))
    {
        this.addWorkplaceButton.addEventListener("click", () => {
            this.showWorkplaceForm();
            this.updateState();
        })
    }
}

/**
 * Проверяем, что у нас есть созданные места работы
 *
 * @returns {boolean}
 */
Resume.prototype.hasWorkplaces = function() {
    const workplaces = this.existingWorkplacesContainer.querySelectorAll("article.resume-item");
    if (workplaces && workplaces.length > 0) {
        return true;
    }

    return false;
}

Resume.prototype.isWorkplaceFormActive = function() {
    if (this.workplaceForm.classList.contains('hidden')) {
        return false;
    }

    return true;
}

/**
 * Пометить кнопку как неактивную
 */
Resume.prototype.disableAddWorkplaceButton = function() {
    const disableClasses = 'disable';
    if (this.isWorkplaceFormActive()) {
        this.addWorkplaceButton.classList.add(disableClasses);
        this.addWorkplaceButton.disabled = true;
    }
}

Resume.prototype.hideWorkplaceForm = function() {
    this.workplaceForm.classList.add('hidden');
}

Resume.prototype.showWorkplaceForm = function() {
    this.workplaceForm.classList.remove('hidden');
}

const resume = new Resume();
resume.updateState();


