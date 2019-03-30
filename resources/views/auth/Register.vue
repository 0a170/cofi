<template>
  <v-container>
    <v-layout>
        <v-form>
        <v-card>
                <v-card-title>
                    Register
                </v-card-title>
                <v-spacer></v-spacer>
                <v-card-actions>
                    <v-text-field
                    v-model="username"
                    :rules="usernameRules"
                    label="Username"
                    ></v-text-field>
                    <v-text-field
                    v-model="email"
                    :rules="emailRules"
                    label="Email"
                    ></v-text-field>
                    <v-text-field
                    v-model="password"
                    :rules="passwordRules"
                    label="Password"
                    ></v-text-field>
                    <v-text-field
                    v-model="passwordConfirm"
                    :rules="confPassRules"
                    label="Confirm Password"
                    ></v-text-field>
                </v-card-actions>
                <v-btn @click="register" class="primary">Login</v-btn>
            </v-card>
        </v-form>
    </v-layout>
  </v-container>
</template>

<script>
import axios from 'axios'

export default {
  data: () => ({
    username: '',
    email: '',
    password: '',
    passwordConfirm: '',
    usernameRules: [
        v => !!v || "Username is required",
    ],
    emailRules: [
        v => !!v || "Email is required"
    ],
    passwordRules: [
        v => !!v || "Password is required"
    ],
    confPassRules: [
        v => !!v || "Password confirmation is required",
        v => this.passwordMatches() || "Must match password"
    ]
  }),
  methods: {
    register () {
      axios.post('/api/register', { username: this.username, email: this.email, password: this.password })
      .then(response => {
        console.log(response.data)
      })
    },
    passwordMatches () {
      return this.password === this.passwordConfirm ? true : false
    }
  }

}
</script>