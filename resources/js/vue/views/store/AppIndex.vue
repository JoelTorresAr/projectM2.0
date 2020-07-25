<template>
  <v-content id="inspire">
    <h3>Categorias de articulos</h3>
    <v-row align="center" justify="center">
      <spinner v-show="loading"></spinner>
      <v-col>
        <div class="d-flex align-content-center justify-space-between flex-wrap">
          <v-card
            v-for="(item, index) in categories"
            :key="index"
            color="#385F73"
            dark
            class="mr-8 mb-16"
          >
            <v-card-title class="headline">{{item.name}}</v-card-title>
            <v-card-actions>
              <router-link :to="{ name: 'articlesbycategory', params: { id: item.id }}">
                <v-btn text>Ver articulos</v-btn>
              </router-link>
            </v-card-actions>
          </v-card>
        </div>
      </v-col>
    </v-row>
  </v-content>
</template>

<script>
export default {
  data: () => ({
    loading: true,
    step: 1,
    categories: []
  }),
  computed: {},
  watch: {},
  created() {
    this.initialize();
  },
  methods: {
    initialize() {
      axios.get("/api/categories").then(({ data }) => {
        this.categories = data;
        this.loading = false;
      });
    }
  }
};
</script>