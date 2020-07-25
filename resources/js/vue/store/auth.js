import router from '../plugins/routes'
import store from '../store/'
export const auth = {
    state: {
        darkStile: true,
        activeUser: null,
        roles: null,
        permissions: null,
        user: null,
        tokenExpireIn: 0,
        storeCar: null,
        igv: 0,
    },
    getters: {
        darkStile: (state) => {
            return state.darkStile;
        },
        getUser: (state) => {
            return state.user;
        },
        getTokenExpireIn: (state) => {
            return state.tokenExpireIn;
        },
        getRoles: (state) => {
            return state.roles
        },
        getPermissions: (state) => {
            return state.permissions
        },
        getStoreCar: (state) => {
            return state.storeCar
        },
        getIgv: (state) => {
            return state.igv
        },
    },
    actions: {
        can({ commit, dispatch }, permission) {
            var jsPermissions = store.getters.getPermissions;
            var permissions = JSON.parse(jsPermissions);
            if (!Array.isArray(permissions)) {
                return router.push({ name: "unauthorized" });
            }
            if (permissions.includes(permission)) {
                return true;
            } else {
                return router.push({ name: "unauthorized" });
            }
        },
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
        SET_TOKEN_EXPIRE_IN(state, value) {
            state.tokenExpireIn = value;
        },
        SET_USER(state, user) {
            state.user = user;
        },
        SET_ROLES(state, roles) {
            state.roles = roles;
        },
        SET_PERMISSIONS(state, permissions) {
            state.permissions = permissions;
        },
        SET_STORE_CAR(state, items) {
            state.storeCar = items;
        },
        SET_IGV(state, igv) {
            state.igv = igv;
        },
    },
    modules: {}
}