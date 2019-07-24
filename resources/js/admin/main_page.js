import CreateNewPostComponent from "./components/EditPostComponent";
import VueRouter from "vue-router";

require('./../bootstrap');
window.Vue = require('vue');
Vue.component('new-post', require('./components/EditPostComponent.vue').default);
Vue.component('posts-list', require('./components/postsList.vue').default);

const app = new Vue({
    el: '.py-4',
});

$(document).ready(function() {
    $('#summernote').summernote({
        height: 300,
        popover: {
            image: [],
            link: [],
            air: []
        }
    });
});
