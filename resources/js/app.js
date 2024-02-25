import Vue from 'vue'
import App from './App'
import router from './router/index.js'
import store from './store.js'
import iView from 'iview';
import 'iview/dist/styles/iview.css';
Vue.use(iView);
import common from './common'
Vue.mixin(common)


window.Vue = require('vue').default;

const app = new Vue({
    el: "#app",
    components: { App },
    router,
    store,
});


Vue.component(
    "app",
    require("./App.vue").default
);


