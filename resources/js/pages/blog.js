import { initBlogSearch } from "../functions";
import $ from 'jquery';

$(function () {
    try {
        initBlogSearch();
    } catch (error) {
        // console.log(error);
    }
});
