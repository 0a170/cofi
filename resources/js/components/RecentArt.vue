<template>
  <v-container>
    <v-layout row wrap>
      <v-flex xs12 sm12>
        <v-select
          v-model="type"
          :items="filterOptions"
          label="Filter By"
          prepend-icon="filter_list"
          @input="filter(type)"
        ></v-select>
      </v-flex>
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
          color="grey lighten-4"
          >
            <v-card-title>
              {{ art.title }}
            </v-card-title>
                <v-img
                 :src="art.src"
                 :aspect-ratio="1"
                >
                  <v-expand-transition>
                    <div
                      v-if="hover"
                      class="d-flex transition-fast-in-fast-out red darken-2 v-card--reveal display-3 white--text"
                      style="height: 100%;"
                    >
                      <v-btn flat color="blue darken-2" @click="openDialog(art)">
                        <v-icon>center_focus_strong</v-icon>
                      </v-btn> 
                      <v-btn flat color="blue darken-2" :to="{ name: 'ArtPage', params: { id: art.id }}">
                        <v-icon large>arrow_forward</v-icon>
                      </v-btn> 
                    </div>
                  </v-expand-transition>
                </v-img>
          </v-card>
        </v-hover>
      </v-flex>
    </v-layout>
    <v-dialog
     v-model="artDialog"
     fullscreen
     full-width
    >
        <v-btn
          color="red lighten-2"
          dark
          @click="artDialog = false"
        >
          <v-icon>close</v-icon>
        </v-btn>

      <v-card>
        <v-img
         :src=selectedArt.src
         aspect-ratio="1"
        >
        </v-img>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import axios from 'axios'

export default {
  data: () => ({
    recentArt: [],
    artDialog: false,
    currentPage: null,
    lastPage: null,
    selectedArt: '',
    atBottomOfPage: false,
    filterOptions: [
      'Recent',
      'Highest Rated',
      'Lowest Rated'
    ],
    type: ''
  }),
  mounted () {
    this.getRecentArt()
    this.scroll()
  },
  methods: {
    getRecentArt() {
      axios.get('/api/recentArt')
      .then(response => {
        this.recentArt = response.data.data
        this.currentPage = response.data.current_page
        this.lastPage = response.data.last_page
      })
      .catch(e => {
        console.log(JSON.stringify(e))
        this.errors.push(e)
      })
    },
    filter(type) {
      console.log(type)
      axios.get('/api/filterArt', { params: { filterType: type }})
      .then(response => {
        this.recentArt = response.data
      })
      .catch(e => {
        // console.log(JSON.stringify(e))
        // this.errors.push(e)
      })
    },
    loadNextPage() {
      let nextPage = this.currentPage + 1
      if (nextPage <= this.lastPage) {
        axios.get(`http://cofi.test/api/recentArt?page=${nextPage}`)
        .then(response => {
          this.recentArt.push(...response.data.data)
          this.currentPage = response.data.current_page
          this.lastPage = response.data.last_page
        });
      }
    },
    // like(art) {
    //   axios.post('/api/like', { artId: artId })
    //   .then(response => {
        
    //   })
    // },
    openDialog(art) {
      this.selectedArt = art
      this.artDialog = true
    },
    scroll () {
      window.onscroll = () => {
        let bottomOfWindow = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop) + window.innerHeight === document.documentElement.offsetHeight

        if (bottomOfWindow) {
         this.atBottomOfPage = true // replace it with your code
         this.loadNextPage()
        }
      }
    }
  }
}
</script>