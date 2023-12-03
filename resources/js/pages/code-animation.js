import { generateCode } from "./functions";
import $ from 'jquery';

$(function () {
    try {
        generateCode();
    } catch (error) {
        // console.log(error);
    }
});
