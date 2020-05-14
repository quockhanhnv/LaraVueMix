require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import {routes} from './routes';
import StoreData from './store';
import MainApp from './components/MainApp.vue';
import {initialize} from './helpers/general';

import {i18n} from "./components/plugins/i18n";

import { firestorePlugin } from 'vuefire'
Vue.use(firestorePlugin)

Vue.use(VueRouter);
Vue.use(Vuex);


const store = new Vuex.Store(StoreData);

const router = new VueRouter({
    routes,
    mode: 'history'
});

initialize(store, router);

const app = new Vue({
    el: '#app',
    router,
    store,
    i18n,
    components: {
        MainApp
    }
});
