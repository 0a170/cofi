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
          <v-card-text>
            {{ art.summary }}
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import axios from 'axios'

export default {
  data: () => ({
    art: '',
    artDialog: false
  }),
  mounted () {
    this.getArt()
  },
  methods: {
    getArt() {
      axios.get('/api/show/' + this.$route.params.id)
      .then(response => {
        console.log('yeah')
        this.art = response.data
      })
      .catch(e => {
        this.errors.push(e)
      })
    },
    like(art) {
      axios.post('/api/like', { artId: artId })
      .then(response => {
        
      })
    }
  }
}
</script>