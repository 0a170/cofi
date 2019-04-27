import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export const store = new Vuex.Store({
  state: {
    accessToken: localStorage.getItem('accessToken') || null
    // user: {
    //   id: null,
    //   accessToken: null
    // }
  },
  getters: {
    getAccessToken (state) {
      return state.accessToken
    }
  },
  mutations: {
    storeToken (state, accessToken) {
      state.accessToken = accessToken
      localStorage.setItem('accessToken', accessToken)
    },
    deleteToken (state) {
      state.accessToken = null
      localStorage.removeItem('accessToken')
    }
  },
  actions: {
    login (store, payload) {
      return new Promise((resolve, reject) => {
        axios.post('/api/login', { username: payload.username, password: payload.password })
        .then(response => {
          store.commit('storeToken', response.data.access_token)
          resolve(response)
        },
        error => {
          reject(error)
        }) 
      })
    },
    logout (store) {
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + store.state.accessToken
      return new Promise((resolve, reject) => {
        if (store.state.accessToken) {
          axios.post('/api/logout')
          .then(response => {
            store.commit('deleteToken')
            resolve(response)
          },
          error => {
            reject(error);
          })
        }
      })
    }
  }  
})