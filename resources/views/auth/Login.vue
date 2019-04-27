<template>
  <v-container>
    <v-form v-model="valid" ref="form">
      <v-card>
        <v-card-title>
            Login
        </v-card-title>
        <divider></divider>
        <v-card-actions>
          <v-text-field
           v-model="username"
           label="Username or Email"
           :rules="usernameRules"
           required
          ></v-text-field>
        </v-card-actions>
        <v-card-actions>
          <v-text-field
           v-model="password"
           label="Password"
           :type="'password'"
           :rules="passwordRules"
           required
          ></v-text-field>
        </v-card-actions>
        <v-card-actions>
          <v-btn @click="login" class="primary">Login</v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </v-container>
</template>

<script>
import axios from 'axios'

export default {
  data: () => ({
    valid: false,
    username: '',
    password: '',
    usernameRules: [
        v => !!v || 'Username or Email is required',
        // v => !!this.login() || 'Incorrect credentials'
    ],
    passwordRules: [
        v => !!v || 'Password is required',
        // v => !!this.login() || 'Incorrect credentials'
    ]
  }),
  methods: {
    login () {
      let payload = null
      this.$store.dispatch('login', { username: this.username, password: this.password})
      .then(response => {
        console.log('post login: ' + response.data)
        if (response.data !== 'Already logged in') {
          this.$router.push({ path: '/' })
        }
      })
      // if (this.$refs.form.validate()) {
        // axios.post('/api/login', { username: this.username, password: this.password })
        // .then(response => {
        //   console.log(JSON.stringify(response.data))
        // })
      // }
    }
  }

}
</script>