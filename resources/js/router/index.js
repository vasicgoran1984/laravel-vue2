import Vue from 'vue'
import Router from 'vue-router'
import About from '../components/pages/About.vue'
import Contact from '../components/pages/Contact.vue'
import hooks from '../components/basic/hooks.vue'
import methods from '../components/basic/methods.vue'
import Home from '../components/pages/home.vue'
import Tags from '../admin/pages/tags.vue'
import Category from '../admin/pages/category.vue'
import adminusers from "../admin/pages/adminusers.vue";

Vue.use(Router)

export default new Router({
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/tags',
            name: 'tags',
            component: Tags
        },
        {
            path: '/category',
            name: 'category',
            component: Category
        },
        {
            path: '/adminusers',
            name: 'adminusers',
            component: adminusers
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
