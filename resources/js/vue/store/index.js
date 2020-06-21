import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from "vuex-persistedstate";

Vue.use(Vuex);

import { auth } from './auth';
const dataState = new createPersistedState({
    paths: ['permissions', 'roles']
})

export default new Vuex.Store({
    strict: true,
    modules: {
        auth,
    },
    plugins: [dataState],
});