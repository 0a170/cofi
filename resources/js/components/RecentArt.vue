<template>
  <v-container>
    <v-layout row wrap>
      <v-flex
       v-for="(art, index) in recentArt"
       :key="index"
       class="pa-1"
       xs12 md6 lg4
      >
        <v-hover>
          <v-card
          slot-scope="{ hover }"
          class="mx-auto"
          >
            <v-card-title>
              {{ art.title }}
            </v-card-title>
                <v-img
                 :src="art.src"
                 aspect-ratio="1"
                >
                  <v-expand-transition>
                    <div
                      v-if="hover"
                      class="d-flex transition-fast-in-fast-out orange darken-2 v-card--reveal display-3 white--text"
                      style="height: 100%;"
                    >
                      {{ index }}
                      <v-btn flat icon color="blue darken-2" @click="like(art)">
                        <v-icon>thumb_up</v-icon>
                      </v-btn> 
                    </div>
                  </v-expand-transition>
                </v-img>
          </v-card>
        </v-hover>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import axios from 'axios'

export default {
  data: () => ({
    recentArt: []
  }),
  mounted () {
    this.getRecentArt()
  },
  methods: {
    getRecentArt() {
      axios.get('/api/recentArt')
      .then(response => {
        this.recentArt = response.data
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