import Vue from 'vue'
import Router from 'vue-router'
import hooks from '../components/basic/hooks.vue'
import methods from '../components/basic/methods.vue'
import Home from '../components/pages/home.vue'
import Tags from '../admin/pages/tags.vue'
import Category from '../admin/pages/category.vue'
import Adminusers from "../admin/pages/adminusers.vue";
import Login from   '../admin/pages/login.vue'
import LoginUser from '../admin/pages/login-user.vue'
import Role from '../admin/pages/role.vue'

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
            component: Adminusers
        },
        {
            path: '/role',
            name: 'role',
            component: Role
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/login-user',
            name: 'login-user',
            component: LoginUser
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
            component: methods,
        },
    ]
})
