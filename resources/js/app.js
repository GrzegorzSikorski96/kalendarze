//require('./bootstrap');

import Vue from 'vue';
import router from './router';
import Vuetify from 'vuetify';
import axios from "axios"
import Vuex from 'vuex';
import store from './store';
import '@fortawesome/fontawesome-free/js/all.min';
import App from './components/App.vue';
import VeeValidate, {Validator} from "vee-validate"
import plValidation from "vee-validate/dist/locale/pl"
import {initialize} from "./helpers/general";

Vue.use(Vuetify, {
    iconfont: "fa5"
});

Vue.use(Vuex);
Vue.use(VeeValidate, {locale: "pl"});
Validator.localize({pl: plValidation});

//window.axios = require('axios');

Vue.prototype.$http = axios;
axios.defaults.baseURL = "http://kalendarze.test/";
//axios.defaults.baseURL = "http://kalendarze.gsikorski.cloud/";
initialize(store, router);

new Vue({
    el: '#app',
    router,
    store,
    components: {App}
});
