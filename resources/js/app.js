require('./bootstrap');

import Vue from 'vue';
import Main from "./components/Main";
import router from  "./router"

new Vue({
    el: '#app',
    router,
    template: '<Main/>',
    components: {Main}
})
