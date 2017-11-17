window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// let token = document.head.querySelector('meta[name="csrf-token"]');
// if (token) {
//     window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
// } else {
//     console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
// }
// window.Vue = require('vue');
import 'weui';
import weui from 'weui.js';
// Vue.component('example', require('./components/Example.vue'));
// const app = new Vue({
    // el: '#app'
// });
weui.alert('test');
