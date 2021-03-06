require('./bootstrap');
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// --Vue--
window.Vue = require('vue');

//suport Componentes
/*Vue.component('spinner', require('./vue/widgets/Spinner').default)
Vue.component('login-admin', require('./vue/views/auth/Login').default)
Vue.component('passport-clients', require('./components/passport/Clients').default)
Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue').default)
Vue.component('passport-personal-access-tokens', require('./components/passport/PersonalAccessTokens.vue').default)*/
Vue.component('app-component', require('./Components/AppComponent.vue').default)
Vue.component('admin-layout', require('./vue/views/layouts/AdminLayout.vue').default)
Vue.component('login', require('./vue/views/auth/Login.vue').default)
Vue.component('spinner', require('./components/widgets/Spinner').default);

//suport Rutas
import router from './vue/plugins/routes'

//support Formularios
import { Form, HasError, AlertError, Errors } from 'vform'

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

//support vue-the-mask
import VueTheMask from 'vue-the-mask'
Vue.use(VueTheMask)

//support vuetify
import vuetify from './vue/plugins/vuetify'

import store from "./vue/store/index"

//support Laravel permission to vuejs
import LaravelPermissionToVueJS from './vue/plugins/laravel-permission-to-vuejs'
Vue.use(LaravelPermissionToVueJS)

//vueDropzone
import vueDropzone from 'vue2-dropzone'
Vue.component('vue-dropzone', vueDropzone);

//idle-vue
import IdleVue from 'idle-vue'
const eventsHub = new Vue()
Vue.use(IdleVue, {
    eventEmitter: eventsHub,
    idleTime: (process.env.MIX_VUE_IDLE_TIME_MIN * 60 * 1000)
})

new Vue({
    el: '#app',
    router,
    vuetify,
    store
});