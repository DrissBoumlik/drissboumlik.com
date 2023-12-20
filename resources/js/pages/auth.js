import { initAuth } from "../functions";
import $ from 'jquery';

$(function () {
    try {
        initAuth();
    } catch (error) {
        // console.log(error);
    }
});
