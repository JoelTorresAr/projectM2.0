import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from "vuex-persistedstate";
import SecureLS from "secure-ls";
var ls = new SecureLS({ isCompression: false });

Vue.use(Vuex);

import { auth } from './auth';
const dataState = new createPersistedState({
    paths: ['auth.permissions', 'auth.roles', 'auth.darkStile', 'auth.tokenExpireIn', 'auth.user'],
    storage: {
        getItem: (key) => ls.get(key),
        setItem: (key, value) => ls.set(key, value),
        removeItem: (key) => ls.remove(key),
    },
})

export default new Vuex.Store({
    modules: {
        auth,
    },
    plugins: [dataState],
});