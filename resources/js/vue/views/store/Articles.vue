<template>
  <v-content>
    <div class="row">
      <spinner v-show="loading"></spinner>
      <div class="col-12">
        <div class="d-flex align-content-center justify-space-between flex-wrap">
          <div
            v-for="(item, index) in articles"
            :key="index"
            class="card"
            style="width: 15rem; height: 22rem; margin: 1rem 1rem 1rem 1rem!important;"
          >
            <img :src="item.file" class="card-img-top" alt="..." style="height: 7rem;" />
            <div class="card-body">
              <h5 class="card-title">{{item.name}}</h5>
              <p class="card-text" style="height: 5rem; margin-bottom: 2rem;">{{item.description}}</p>
              <span>
                <strong>S./{{item.saleprice}}</strong>
              </span><br/>
              <v-btn color="primary" class="mt-2 mb-2" :to="{ name: 'articlebyid', params: { id: item.id }}">Comprar</v-btn>
            </div>
          </div>
        </div>
      </div>
    </div>
  </v-content>
</template>

<script>
export default {
  data: () => ({
    loading: true,
    articles: []
  }),
  computed: {},
  watch: {},
  created() {
    this.initialize();
  },
  methods: {
    initialize() {
      var categoriId = this.$route.params.id;
      axios
        .get(`/api/articles/searchbycategoryid/${categoriId}`)
        .then(({ data }) => {
          this.articles = data;
          this.loading = false;
        });
    }
  }
};
</script>