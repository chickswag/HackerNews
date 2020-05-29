require('./bootstrap');

import Vue from 'vue';
import Main from "./components/Main";
import router from  "./router";
import pagination from "./components/Pagination";
Vue.component( 'pagination',require('./components/Pagination.vue').default);

new Vue({
    el: '#app',
    router,
    template: '<Main/>',
    components: {
        'Main': Main,
    }
})
