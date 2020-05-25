require('./bootstrap');
window.Vue = require('vue');

Vue.component( 'Posts',require('./components/Posts.vue').default);

const app = new Vue({
    el: '#app',
});
