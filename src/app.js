window.Vue = require('vue').default;

window.axios = require('axios');

//componentes

import form from './components/form.vue';

Vue.component('sms-form', form);

const app = new Vue({
    el: "#app",
});
