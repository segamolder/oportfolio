
require('./bootstrap');

window.Vue = require('vue');

Vue.component('blog', require('./components/blogComponent.vue').default);
Vue.component('blog-post-view', require('./components/BlogPostView.vue').default);
Vue.component('timer', require('./components/Timer.vue').default);

const blog = new Vue({
    el: '.py-4',
});

