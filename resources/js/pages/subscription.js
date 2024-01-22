import {initSubscriptionForm, initSubscriptionUpdateForm} from "../functions";
import $ from 'jquery';

$(function () {
    try {
        initSubscriptionForm();
        initSubscriptionUpdateForm();
    } catch (error) {
        // console.log(error);
    }
});
