import { initContactFormEvent, generateCode } from "./functions";

$(function () {
    try {
        generateCode();
        initContactFormEvent();
    } catch (error) {
        // console.log(error);
        throw error
    }
});
