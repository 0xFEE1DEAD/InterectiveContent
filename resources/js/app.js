import Vue from 'vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import BV from 'bootstrap-vue'
Vue.use(BV)

window.axios = require('axios');
window.axios.defaults.withCredentials = true

Vue.component('main-comp', require('./components/mainComp.vue').default);

export const bus = new Vue(); //вместо vuex

const app = new Vue({
    el: '#app',
    template: '<main-comp />'
});
