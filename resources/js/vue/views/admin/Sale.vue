<template>
  <v-main>
    <v-container fill-height fluid>
      <v-row align="center" justify="center">
        <v-col cols="12" sm="12" md="10">
          <v-card>
            <v-card-title class="title font-weight-regular justify-space-between">
              <h3 class="text-center">
                <strong>{{currentTitle}}</strong>
              </h3>
              <v-avatar color="primary" class="subheading white--text" size="24" v-text="step"></v-avatar>
            </v-card-title>
            <v-window v-model="step">
              <v-window-item :value="1">
                <v-card-text>
                  <v-row justify="center">
                    <v-col cols="12" sm="12" md="6">
                      <v-card>
                        <v-card-title class="title font-weight-regular justify-space-between">
                          <v-text-field
                            v-model="article_code"
                            label="Codigo de producto*"
                            placeholder="_ _ _ _ _ _"
                            v-mask="['######', '######']"
                            required
                          />
                          <v-btn color="primary" class="mb-2" @click="searchArticlebyId">Buscar</v-btn>
                        </v-card-title>
                        <v-card-text>
                          <v-row>
                            <v-col cols="12" v-if="!loading.article">
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
                                            <strong>S./{{trunc(article.saleprice)}}</strong>
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
                                          <v-btn
                                            color="primary"
                                            fab
                                            x-small
                                            dark
                                            @click="cantidad--"
                                          >
                                            <v-icon>mdi-minus</v-icon>
                                          </v-btn>
                                        </div>
                                        <div>
                                          <input
                                            v-model="cantidad"
                                            class="shop__inp--small text-center"
                                            v-mask="['######', '######']"
                                            required
                                          />
                                        </div>
                                        <div>
                                          <v-btn
                                            color="primary"
                                            fab
                                            x-small
                                            dark
                                            @click="cantidad++"
                                          >
                                            <v-icon>mdi-plus</v-icon>
                                          </v-btn>
                                        </div>
                                      </div>
                                    </v-list-item>
                                    <v-list-item two-line>
                                      <v-list-item-content>
                                        <v-list-item-title>
                                          Precio Total:
                                          <strong>S./{{trunc(importe)}}</strong>
                                        </v-list-item-title>
                                        <v-list-item-title v-if="article.offer!=null">
                                          Descuento:
                                          <strong>S./{{trunc(totaldiscount)}}</strong>
                                        </v-list-item-title>
                                      </v-list-item-content>
                                    </v-list-item>
                                  </v-list>
                                </v-col>
                              </v-row>
                            </v-col>
                            <v-col cols="12" v-if="loading.article">
                              <v-boilerplate class="mb-6" type="card-avatar, article, actions"></v-boilerplate>
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
                    <v-col cols="12" sm="12" md="6">
                      <v-card>
                        <v-card-title>
                          <h4 class="text-center">
                            <strong>Lista de articulos</strong>
                          </h4>
                        </v-card-title>
                        <v-card-text>
                          <v-simple-table>
                            <template v-slot:default>
                              <thead>
                                <tr>
                                  <th class="text-left">Id</th>
                                  <th class="text-left">Nombre</th>
                                  <th class="text-left">Cantidad</th>
                                  <th class="text-left">Total</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in carrito" :key="item.id">
                                  <td>{{ item.id }}</td>
                                  <td>{{ item.name }}</td>
                                  <td>{{ item.quantity }}</td>
                                  <td>S./{{ trunc(item.import) }}</td>
                                  <td>
                                    <v-btn color="red" fab x-small dark @click="removeItem(item)">
                                      <v-icon>mdi-delete</v-icon>
                                    </v-btn>
                                  </td>
                                </tr>
                              </tbody>
                            </template>
                          </v-simple-table>
                        </v-card-text>
                        <v-card-actions>
                          <strong>
                            <span>IGV:</span>
                          </strong>
                          <v-spacer></v-spacer>
                          <span>S./{{trunc(totalIgv)}}</span>
                        </v-card-actions>
                        <v-card-actions>
                          <strong>
                            <span>Costo total:</span>
                          </strong>
                          <v-spacer></v-spacer>
                          <span>S./{{trunc(newItem.totalpay)}}</span>
                        </v-card-actions>
                      </v-card>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-window-item>
              <v-window-item :value="2">
                <v-card>
                  <v-card-text>
                    <v-row>
                      <v-col cols="12" sm="4" md="4">
                        <v-text-field v-model="newItem.dni" label="DNI"></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="4" md="4">
                        <v-select
                          v-model="newItem.prooftype_id"
                          :items="prooftype"
                          label="Tipo de comprobante*"
                          required
                          item-text="name"
                          item-value="id"
                        ></v-select>
                      </v-col>
                      <v-col cols="12" sm="4" md="4">
                        <v-select
                          v-model="newItem.paytype"
                          :items="paytype"
                          label="Metodo de pago*"
                          required
                          item-text="name"
                          item-value="id"
                        ></v-select>
                      </v-col>
                    </v-row>
                  </v-card-text>
                </v-card>
              </v-window-item>
            </v-window>
            <v-divider></v-divider>
            <v-card-actions>
              <v-btn :disabled="step === 1" text @click="step--">Volver</v-btn>
              <v-spacer></v-spacer>
              <v-btn
                v-if="step !== 2"
                :disabled="step === 3 || carrito.length==0"
                color="primary"
                depressed
                @click="step++"
              >Siguiente</v-btn>
              <v-btn v-if="step === 2" color="primary" depressed @click="save">Guardar</v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-main>
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
    loading: {
      article: false
    },
    step: 1,
    article_code: 1,
    igv: { id: 0, mount: 0 },
    article: [],
    cantidad: 0,
    importe: 0,
    totaldiscount: 0,
    carrito: [],
    prooftype: [],
    paytype: [
      { id: "CASH", name: "Efectivo" },
      { id: "CARD", name: "Tarjeta" }
    ],
    newItem: new Form({
      dni: "74436568",
      igv_id: "",
      prooftype_id: 1,
      paytype: "CASH",
      totalpay: 0,
      salearticles: []
    })
  }),
  computed: {
    currentTitle() {
      switch (this.step) {
        case 1:
          return "Registro de articulos";
        case 2:
          return "Datos de compra";
        default:
          return "Compra procesada";
      }
    },
    totalIgv() {
      var pf = parseFloat(this.newItem.totalpay)
      var igv = parseFloat(this.igv.mount)
      var pi = (pf * 100) / (100 + igv)
      var igvT = (pi * igv) / 100
      return igvT
    },
    descuento() {
      this.article;
    }
  },
  watch: {
    cantidad(val) {
      this.CalcPrice()
    },
    carrito(val) {
      this.newItem.salearticles = val;
    },
    step(val) {},
    carrito(val) {
      var total = 0;
      if (val.length != 0) {
        this.carrito.forEach(element => {
          total += element.import;
        });
      }
      this.newItem.totalpay = total
    }
  },
  created() {
    axios.get(`/api/igvs/current`).then(({ data }) => {
      this.igv = data;
      this.newItem.igv_id = data.id;
    });
    axios.get("/api/prooftypes").then(({ data }) => {
      this.prooftype = data;
    });
    this.searchArticlebyId();
  },
  methods: {
    searchArticlebyId() {
      this.loading.article = true;
      axios
        .get(`/api/articles/searchbyid/${this.article_code}`)
        .then(({ data }) => {
          this.article = data
          var pi = parseFloat(this.article.saleprice)
          var pf = pi + (pi * this.igv.mount) / 100
          this.article.saleprice = pf
          this.cantidad = 1;
          this.CalcPrice();
          this.loading.article = false;
        });
    },
    save() {
      this.newItem
        .post("/api/sales/store")
        .then(({ data }) => {
          if (data.status == "200") {
            this.searchArticlebyId();
            this.step++;
            this.emptyForm();
            toastr.success("Compra registrada");
          }
        })
        .catch(error => {
          toastr.error("Error al registrar");
        });
    },
    emptyForm() {
      this.carrito = [];
      this.newItem.reset();
      this.newItem.igv_id = this.igv.id;
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
      var totalprice = this.cantidad * this.article.saleprice
      if (this.article.offer != null) {
        this.totaldiscount = (totalprice * this.article.offer.discount) / 100
        totalprice -= this.totaldiscount;
      }
      this.importe = totalprice
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