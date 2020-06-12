import Vue from "vue";
//suport Rutas
import router from '../plugins/routes'
export default {
    state: {
        drawer: false,
        darkStile: true,
        group: null,
        activeUser: null,
        user: null,
        tokenExpireIn: 0,
    },
    getters: {
        drawer: (state) => {
            return state.drawer;
        },
        group: (state) => {
            return state.group;
        },
        darkStile: (state) => {
            return state.darkStile;
        },
        getUser: (state) => {
            return state.user;
        },
        getTokenExpireIn: (state) => {
            return state.tokenExpireIn;
        },
    },
    actions: {
        async login({ commit, dispatch }, credentials) {
            let response = { 'state': 500, 'messaje': 'Error de servidor' };
            await axios.post("/api/admin/login", credentials).then(res => {
                commit("SET_TOKEN_EXPIRE_IN", res.data.expires_in);
                dispatch('getUser');
                response = { 'state': 200, 'messaje': 'Credenciales validas' };
            }).catch(error => {
                commit("SET_TOKEN_EXPIRE_IN", 0);
            });
            return response;
        },
        async getUser({ commit }) {
            await axios.get("/api/admin/me")
                .then(res => {
                    commit("SET_USER", res.data);
                    return true;
                })
                .catch(error => {
                    commit("SET_USER", null);
                    return false;
                });
        },
        async authenticate({ dispatch }) {
            let state = false;
            await axios.get("/api/admin/me").then(res => {
                    if (res !== undefined) {
                        state = true;
                        dispatch('getUser');
                    }
                })
                .catch(err => {
                    state = false;
                    router.push({ name: "authenticate" });
                });
            return state;
        },
        authenticate2({ commit }) {
            return axios.get("/api/admin/me").then((payload) => {
                    if (payload) {
                        if (router.currentRoute.name == 'authenticate') {
                            router.push({ name: "admin" });
                        }
                        commit("SET_USER", payload.data);
                    } else {
                        console.log('fallo')
                    }
                    return true;
                })
                .catch((e) => {
                    commit("SET_USER", null);
                    router.push({ name: "authenticate" });
                    return false;
                });
        },
    },
    mutations: {
        SET_DARK_STILE(state, value) {
            state.darkStile = value;
        },
        SET_DRAWER_STATE(state, value) {
            state.drawer = value;
        },
        SET_GROUP_STATE(state, value) {
            state.group = value;
        },
        SET_TOKEN_EXPIRE_IN(state, value) {
            state.tokenExpireIn = value;
        },
        SET_USER(state, user) {
            state.user = user;
        },
    },
    modules: {}
}