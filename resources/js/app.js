import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import VueAxios from 'vue-axios';
import axios from 'axios';

Vue.use(VueRouter)
Vue.use(Vuetify)
Vue.use(VueAxios, axios)

import App from '../views/App'
import Home from '../views/Home'
import Welcome from '../views/Welcome'
import Users from '../views/Users'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/welcome',
            name: 'welcome',
            component: Welcome,
        },
        {
            path: '/users',
            name: 'users',
            component: Users
        }
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});