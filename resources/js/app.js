import Vue from 'vue'
import App from './App'
import router from './router/index.js'

import iView from 'iview';
import 'iview/dist/styles/iview.css';

Vue.use(iView);

/* eslint-disable no-new */
new Vue({
    el: '#app',
    components: { App },
    router,
    template: '<App/>'
})
