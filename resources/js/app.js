import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import VueAxios from 'vue-axios'
import axios from 'axios'

Vue.use(VueRouter)
Vue.use(Vuetify)
Vue.use(VueAxios, axios)

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);
 
Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

import App from '../views/App'
import Home from '../views/Home'
import Welcome from '../views/Welcome'
import ArtPage from '../views/ArtPage'
import Users from '../views/Users'
import Login from '../views/auth/Login'
import Register from '../views/auth/Register'
import { store } from './store'

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
            path: '/art/:id',
            name: 'ArtPage',
            component: ArtPage,
        },
        {
            path: '/users',
            name: 'users',
            component: Users
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        }
    ],
});

// router.beforeEach((to, from, next) => {
//     var loggedIn = localStorage.getItem('accessToken')

//     if (loggedIn !== '' || loggedIn !== null) {
//         return next('/login')
//     } else if (to.path('/login') && loggedIn) {
//         next('/')
//     } else {
//         next()
//     }
// })

const app = new Vue({
    el: '#app',
    components: { App },
    store,
    router,
});

export default app;