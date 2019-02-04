<template>
  <container>
    <v-card>
      <v-card-title>
        Newest Submissions
      </v-card-title>
      <v-layout>
        <v-flex
         v-for="art in recentArt"
         :key="art"
         xs4
         d-flex
        >
          <v-img
           :src="art.src"
           aspect-ratio="1"
          ></v-img>
        </v-flex>
      </v-layout>
    </v-card>
  </container>
</template>

<script>
export default {
  data: () => ({
    recentArt: []  
  }),
  methods: {
    getRecentArt() {
      axios.get('api/recentArt')
      .then(response => {
        this.recentArt = response.data
      })
      .catch(e => {
        this.errors.push(e)
      })
    }
  }
}
</script>