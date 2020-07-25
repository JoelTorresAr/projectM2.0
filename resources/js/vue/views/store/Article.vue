<template>
  <v-content>
    <v-card-text>
      <v-row justify="center">
        <spinner v-show="loading.article"></spinner>
        <v-col cols="12">
          <v-card v-if="!loading.article">
            <v-card-text>
              <v-row>
                <v-col cols="12">
                  <v-row no-gutters justify="center">
                    <v-avatar class="profile" color="grey" size="300" tile>
                      <v-img :src="article.file"></v-img>
                    </v-avatar>
                    <v-col class="py-0">
                      <v-list dense max-width="20rem">
                        <v-list-item>
                          <v-list-item-content two-line>
                            <v-list-item-title>
                              <b>
                                <strong>{{article.name}}</strong>
                              </b>
                            </v-list-item-title>
                            <v-list-item-title>
                              <b>
                                <strong>S./{{article.saleprice}}</strong>
                              </b>
                            </v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                        <v-list-item three-line>
                          <v-list-item-content>
                            <v-list-item-subtitle>Descripcion:</v-list-item-subtitle>
                            <v-list-item-subtitle>{{article.description}}</v-list-item-subtitle>
                          </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                          <v-list-item-content>
                            <v-list-item-subtitle>Stock: {{article.stock}}</v-list-item-subtitle>
                          </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                          <v-list-item-content>
                            <v-list-item-subtitle>Cantidad:</v-list-item-subtitle>
                          </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                          <div class="shop__article__quantity">
                            <div>
                              <v-btn color="primary" fab x-small dark @click="cantidad--">
                                <v-icon>mdi-minus</v-icon>
                              </v-btn>
                            </div>
                            <div>
                              <input
                                v-model="cantidad"
                                class="store__inp--small text-center"
                                v-mask="['######', '######']"
                                required
                              />
                            </div>
                            <div>
                              <v-btn color="primary" fab x-small dark @click="cantidad++">
                                <v-icon>mdi-plus</v-icon>
                              </v-btn>
                            </div>
                          </div>
                        </v-list-item>
                        <v-list-item>
                          <v-list-item-content>
                            <v-list-item-title>
                              Precio Total:
                              <strong>S./{{importe}}</strong>
                            </v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                      </v-list>
                    </v-col>
                  </v-row>
                </v-col>
              </v-row>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="primary" class="mb-2" @click="addtoCar">Agregar al carrito</v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-card-text>
  </v-content>
</template>

<script>
export default {
  components: {
    // Create a new component that
    // extends v-skeleton-loader
    VBoilerplate: {
      functional: true,

      render(h, { data, props, children }) {
        return h(
          "v-skeleton-loader",
          {
            ...data,
            props: {
              elevation: 2,
              ...props
            }
          },
          children
        );
      }
    }
  },
  data: () => ({
    loading: {
      article: true
    },
    article: [],
    cantidad: 1,
    importe: 0,
    igv: {},
    carrito: [],
    newItem: new Form({
      dni: "74436568",
      igv_id: "",
      prooftype_id: 1,
      paytype: "CASH",
      totalpay: "",
      salearticles: []
    })
  }),
  computed: {
  },
  watch: {
    cantidad(val) {
      this.CalcPrice();
    },
    carrito(val) {
      this.newItem.salearticles = val;
    }
  },
  created() {
    this.initialize();
  },
  methods: {
    initialize() {
      var itemId = this.$route.params.id;
      axios.get(`/api/articles/searchbyid/${itemId}`).then(({ data }) => {
        this.loading.article = false;
        this.article = data
      });

      axios.get(`/api/igvs/current`).then(({ data }) => {
        this.igv = data;
        this.newItem.igv_id = data.id;
        this.CalcPrice()
      });

    },
    addtoCar() {
      var newArticle = {
        id: this.article.id,
        name: this.article.name,
        quantity: this.cantidad,
        import: this.importe
      };
      this.carrito.push(newArticle);
    },
    removeItem(item) {
      const index = this.carrito.indexOf(item);
      this.carrito.splice(index, 1);
    },
    CalcPrice() {
      this.importe = this.trunc((this.cantidad * this.article.saleprice)+(this.article.saleprice * this.igv.mount) / 100)
    },
    trunc(x, posiciones = 2) {
      var s = x.toString();
      var l = s.length;
      var decimalLength = s.indexOf(".") + 1;

      if (l - decimalLength <= posiciones) {
        return x;
      }
      // Parte decimal del número
      var isNeg = x < 0;
      var decimal = x % 1;
      var entera = isNeg ? Math.ceil(x) : Math.floor(x);
      // Parte decimal como número entero
      // Ejemplo: parte decimal = 0.77
      // decimalFormated = 0.77 * (10^posiciones)
      // si posiciones es 2 ==> 0.77 * 100
      // si posiciones es 3 ==> 0.77 * 1000
      var decimalFormated = Math.floor(
        Math.abs(decimal) * Math.pow(10, posiciones)
      );
      // Sustraemos del número original la parte decimal
      // y le sumamos la parte decimal que hemos formateado
      var finalNum =
        entera +
        (decimalFormated / Math.pow(10, posiciones)) * (isNeg ? -1 : 1);

      return finalNum;
    }
  }
};
</script>
<style>
.shop__article__quantity {
  display: flex;
  width: 95%;
  justify-content: flex-start;
}
.store__inp--small {
  width: 50px !important;
}
</style>