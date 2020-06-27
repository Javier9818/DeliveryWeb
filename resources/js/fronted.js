window.Vue = require('vue');

require('./bootstrap');
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)


import VueCookies from 'vue-cookies'
Vue.use(VueCookies)
Vue.$cookies.config('1d')

Vue.component('mapa-interactivo', require('./components/maps/MapaInteractivo.vue').default);
//FRONT CLIENTE
Vue.component('modal-carrito', require('./components/front/ModalCarrito.vue').default)
Vue.component('modal-pedidos', require('./components/front/ModalPedidos.vue').default)

/*Front*/
Vue.component('front-categories-component', require('./components/front/categoriesComponent.vue').default)
Vue.component('front-menu-component', require('./components/front/menuComponent.vue').default)
Vue.component('front-cart-component', require('./components/front/cartComponent.vue').default)
Vue.component('form-wizard-unt', require('./components/formWizard/App.vue').default);
Vue.component('front-pedidos-component', require('./components/front/pedidosComponent.vue').default);
Vue.component('front-seguimiento-component', require('./components/front/seguimientoComponent.vue').default);


Vue.component('tenvio-promo-component', require('./components/landing_pages/tenvio_promo.vue').default);
Vue.component('tenvio-registro-component', require('./components/landing_pages/tenvio_registro.vue').default);
Vue.component('tenvio-padre-component', require('./components/landing_pages/tenvio_padre.vue').default);

Vue.component('recover-component', require('./components/front/recoverComponent.vue').default);
Vue.component('post-recover-component', require('./components/front/postRecoverComponent.vue').default);
// const EventBus = new Vue();
const app = new Vue({
    el: '#app',
});
