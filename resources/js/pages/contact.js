import { initContactFormEvent } from "./functions";
import $ from 'jquery';

$(function () {
    try {
        initContactFormEvent();
    } catch (error) {
        // console.log(error);
    }
});
