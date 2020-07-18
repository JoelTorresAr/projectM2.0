<template>
  <v-content>
    <v-container fill-height fluid>
      <v-row align="center" justify="center">
        <v-col cols="12" sm="8" md="10">
          <v-card>
            <v-card-title>
              <span>Cargar Nuevo Articulo</span>
            </v-card-title>
            <v-window v-model="step">
              <v-window-item>
                <v-row align="center" justify="center">
                  <v-col cols="12" sm="12" md="6">
                    <v-row>
                      <v-col cols="12">
                        <v-row>
                          <v-col cols="8">
                            <v-text-field
                              v-model="article_code"
                              label="Codigo de producto*"
                              placeholder="_ _ _ _ _ _"
                              v-mask="['######', '######']"
                              required
                            />
                          </v-col>
                          <v-col cols="4" align="right">
                            <v-btn color="primary" class="mb-2" @click="searchArticle">Buscar</v-btn>
                          </v-col>
                        </v-row>
                      </v-col>
                      <v-col cols="12" v-if="!articleLoading">
                        <v-row no-gutters justify="center">
                          <v-avatar class="profile" color="grey" size="300" tile>
                            <v-img src="https://cdn.vuetifyjs.com/images/profiles/marcus.jpg"></v-img>
                          </v-avatar>
                          <v-col class="py-0">
                            <v-list dense>
                              <v-list-item>
                                <v-list-item-content>
                                  <v-list-item-title>Nombre del Articulo</v-list-item-title>
                                </v-list-item-content>
                              </v-list-item>
                              <v-list-item>
                                <v-list-item-content>
                                  <v-list-item-title>Precio</v-list-item-title>
                                </v-list-item-content>
                              </v-list-item>
                              <v-list-item>
                                <v-list-item-content>
                                  <v-list-item-subtitle>Descripcion:</v-list-item-subtitle>
                                </v-list-item-content>
                              </v-list-item>
                              <v-list-item>
                                <v-list-item-content>
                                  <v-list-item-subtitle>Stock:</v-list-item-subtitle>
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
                                    <v-btn color="primary" fab x-small dark @click="cantidad++">
                                      <v-icon>mdi-plus</v-icon>
                                    </v-btn>
                                  </div>
                                  <div>
                                    <input
                                      v-model="cantidad"
                                      class="shop__inp--small m-5 text-center"
                                      v-mask="['######', '######']"
                                      required
                                    />
                                  </div>
                                  <div>
                                    <v-btn color="primary" fab x-small dark @click="cantidad--">
                                      <v-icon>mdi-minus</v-icon>
                                    </v-btn>
                                  </div>
                                </div>
                              </v-list-item>
                              <v-list-item>
                                <v-list-item-content>
                                  <v-list-item-title>Precio Total:</v-list-item-title>
                                </v-list-item-content>
                              </v-list-item>
                            </v-list>
                          </v-col>
                        </v-row>
                        <v-col cols="12" align="right">
                          <v-btn color="primary" class="mb-2">Agregar al carrito</v-btn>
                        </v-col>
                      </v-col>
                      <v-col cols="12" v-if="articleLoading">
                        <v-boilerplate class="mb-6" type="card-avatar, article, actions"></v-boilerplate>
                      </v-col>
                    </v-row>
                  </v-col>
                  <v-col cols="12" sm="12" md="6">
                    <v-boilerplate class="mb-6" type="card-avatar, article, actions"></v-boilerplate>
                  </v-col>
                </v-row>
              </v-window-item>
            </v-window>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
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
  props: {
    source: String
  },
  data: () => ({
    articleLoading: false,
    article_code: "0",
    article: "",
    cantidad: "0",
    importe: "10",
    carrito: []
  }),
  watch: {
    cantidad(val) {
      console.log(this.article);
    }
  },
  created() {
    this.searchArticle();
  },
  methods: {
    searchArticle() {
      axios
        .get(`/api/articles/search/${this.article_code}`)
        .then(({ data }) => {
          this.article = data;
          this.loadingArticle = false;
        });
    }
  }
};
</script>
<style>
:root {
  --background: #e0e5ec;
  --gray: #797d7f;
}
.neuro__color {
  background-color: #e0e5ec;
}

.shop {
  /* Basic styling and alignment */
  margin-left: auto;
  margin-right: auto;

  height: 30rem;
  background-color: var(--background);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  border-radius: 12px;
  /* Basic styling and alignment */ /* For Neumorphism Effect */
  box-shadow: 9px 9px 16px rgba(163, 177, 198, 0.6),
    -9px -9px 16px rgba(255, 255, 255, 0.5);
  /* For Neumorphism Effect */
}
.shop__controls {
  display: flex;
  width: 95%;
  justify-content: space-evenly;
  align-items: center;
  margin-bottom: 25px;
}
.shop__article__quantity {
  display: flex;
  width: 95%;
  justify-content: flex-start;
}
.shop__btn {
  cursor: pointer;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  background: linear-gradient(145deg, #cdcdcd, #adadad);
  box-shadow: -8px -8px 20px #fff9, -5px -5px 10px 0px #ffff, 8px 8px 20px #0001,
    5px 5px 6px 0px #0001;
  color: var(--gray);
}
.shop__btn:active {
  box-shadow: inset -8px -8px 20px 0px #fff9, inset -5px -5px 8px 20px #0001,
    inset 5px 5px 6px 0px #0001;
}
.shop__btn--small {
  min-width: 50px;
  min-height: 50px;
}
.shop__inp--small {
  width: 50px !important;
}
.shop__inp--medium {
  width: 120px !important;
}
.shop__title {
  font-weight: 600;
  font-size: 0.8em;
  color: #a1a1a1;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin: 0;
}
</style>