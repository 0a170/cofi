<template>
  <div>
    <v-toolbar>
      <v-toolbar-side-icon class="hidden-md-and-up" @click.stop="drawer = !drawer"></v-toolbar-side-icon>
      <v-toolbar-title>
        <v-btn flat :to="{ name: 'home' }">Cofi</v-btn>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-toolbar-items class="hidden-sm-and-down">
        <v-btn flat>Link One</v-btn>
        <v-btn flat>Link Two</v-btn>
        <v-btn flat v-if="userAccessToken" @click="attemptLogout">
          <v-avatar
           :tile=false
           size="40px"
           color="grey lighten-4"
          >
            <img :src="genericAvatar" alt="genericAvatar">
          </v-avatar>
        </v-btn>
        <v-btn v-else flat :to="{ name: 'login' }">Log in</v-btn>
      </v-toolbar-items>
    </v-toolbar>
    <v-navigation-drawer v-model="drawer" class="hidden-md-and-up">
      <v-toolbar flat>
        <v-list>
          <v-list-tile>
            <v-list-tile-content>
              Application
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-toolbar>
      <v-list>
        <v-list-tile>
          <v-list-tile-content>
            <v-btn flat>Link One</v-btn>
          </v-list-tile-content>
        </v-list-tile>
        <v-list-tile>
          <v-list-tile-content>
            <v-btn flat>Link Two</v-btn>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>
    <v-snackbar
     v-model="userLoggedSnackbar"
     :bottom="y === 'bottom'"
     :left="x === 'left'"
     :multi-line="mode === 'multi-line'"
     :right="x === 'right'"
     :timeout="timeout"
     :top="y === 'top'"
     :vertical="mode === 'vertical'"
    >
      {{ text }}
      <v-btn
        color="pink"
        flat
        @click="snackbar = false"
      >
        Close
      </v-btn>
    </v-snackbar>
    <router-view></router-view>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data: () => ({
    drawer: null,
    userLoggedSnackbar: false,
    y: 'top',
    x: null,
    mode: '',
    text: '',
    timeout: 3000,
    genericAvatar: "https://www.premierthermal.com/wp-content/uploads/avatar-generic.jpg"
  }),
  computed: {
    userAccessToken () {
      // return this.$store.state.accessToken
      return this.$store.getters.getAccessToken

    }
  },
  methods: {
    attemptLogout () {
      if (this.userAccessToken) {
        this.$store.dispatch('logout')
        .then(response => {
          this.text = response.data
          this.userLoggedSnackbar = true 
          this.$router.push({ path: '/' })
        })
      }
    }
  }
}
</script>