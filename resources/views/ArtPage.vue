<template>
  <v-container>
    <v-layout row wrap>
      <v-flex xs12 md6 lg6 class="pa-1">
        <v-img :src="art.src"></v-img>
      </v-flex>
      <v-flex xs12 md6 lg6 class="pa-1">
        <v-card>
          <v-card-title primary-title>
            {{ art.title }}
          </v-card-title>
          <v-card-text class="overflow: scroll-y; max-height: 400px">
            {{ art.summary }}
          </v-card-text>
          <v-card-actions>
            <v-btn flat icon @click="like(art.id)">
              <v-icon v-if="art.isLiked" color="green">thumb_up</v-icon>
              <v-icon v-else>thumb_up</v-icon> {{ art.likes }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters([
      'getAccessToken'
    ])
  },
  data: () => ({
    art: '',
    artDialog: false
  }),
  mounted () {
    this.getArt()
  },
  methods: {
    getArt() {
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.getAccessToken
      axios.get('/api/show/' + this.$route.params.id)
      .then(response => {
        this.art = response.data
      })
      .catch(e => {
        this.errors.push(e)
      })
    },
    like(artId) {
      if (!this.getAccessToken) {
        this.$router.push({name: 'login'})
        return
      }
      var vote = ''; 
      vote = (this.art.isLiked) ? false : true
      // console.log(this.getAccessToken)
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.getAccessToken
      axios.post('/api/like/' + artId, {params: {vote: vote}})
      .then(response => {
        this.art.isLiked = vote
        this.art.likes = response.data
      })
    }
  }
}
</script>