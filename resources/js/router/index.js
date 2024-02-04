import Vue from 'vue'
import Router from 'vue-router'
import About from '../components/pages/About.vue'
import Contact from '../components/pages/Contact.vue'
import hooks from '../components/basic/hooks.vue'
import methods from '../components/basic/methods.vue'
import Home from '../components/pages/home.vue'

Vue.use(Router)

export default new Router({
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/about',
            name: 'about',
            component: About
        },
        {
            path: '/contact',
            name: 'contact',
            component: Contact
        },

        // vue hooks
        {
            path: '/hooks',
            name: 'hooks',
            component: hooks
        },

        // vue methods
        {
            path: '/methods',
            name: 'methods',
            component: methods
        },
    ]
})
