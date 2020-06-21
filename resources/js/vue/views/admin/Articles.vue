<template>
  <v-app id="app">
    <v-card>
      <v-card-title>
        Articulos
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-autocomplete
          v-model="subsidiary_selected"
          :items="subsidiaries"
          append-icon="mdi-magnify"
          item-text="name"
          item-value="id"
          label="Subsidiaria"
          :loading="loadingSubsidiary"
          no-data-text="No hay subsidiarias registradas"
          hint="*Selecciona una subsidiaria para cargar los articulos"
          persistent-hint
        ></v-autocomplete>
      </v-card-title>
      <v-data-table
        :headers="headers"
        :items="articles"
        item-key="id"
        :sort-by="['shelf', 'category']"
        :sort-desc="[false, false]"
        multi-sort
        class="elevation-1"
        :loading="loading"
        loading-text="Cargando... Por favor espere"
      >
        <template v-slot:top>
          <v-toolbar flat class="mt-2">
            <v-spacer></v-spacer>
            <v-dialog v-model="dialogForm" persistent max-width="600px">
              <template v-slot:activator="{ on }">
                <v-btn color="primary" class="mb-2" v-on="on">Agregar nuevo</v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>
                <v-card-text>
                  <form @submit.prevent="save">
                    <v-container>
                      <v-row>
                        <v-col cols="12">
                          <v-text-field
                            v-model="editedItem.name"
                            label="Nombre*"
                            required
                            :class="{ 'is-invalid': editedItem.errors.has('name') }"
                          ></v-text-field>
                          <has-error class="red--text" :form="editedItem" field="name"></has-error>
                        </v-col>
                        <v-col cols="6">
                          <v-autocomplete
                            v-model="editedItem.provider_id"
                            :items="providers"
                            item-text="name"
                            item-value="id"
                            label="Proveedor*"
                            :loading="loadingProvider"
                            no-data-text="No hay provedores registrados"
                            :class="{ 'is-invalid': editedItem.errors.has('provider_id') }"
                          ></v-autocomplete>
                          <has-error class="red--text" :form="editedItem" field="provider_id"></has-error>
                        </v-col>
                        <v-col cols="6">
                          <v-autocomplete
                            v-model="editedItem.category_id"
                            :items="categories"
                            item-text="name"
                            item-value="id"
                            label="Categoria*"
                            :loading="loadingCategory"
                            no-data-text="No hay provedores registrados"
                            :class="{ 'is-invalid': editedItem.errors.has('category_id') }"
                          ></v-autocomplete>
                          <has-error class="red--text" :form="editedItem" field="category_id"></has-error>
                        </v-col>
                        <v-col cols="6">
                          <v-select
                            v-model="editedItem.shelf_id"
                            :items="shelves"
                            label="Stand*"
                            required
                            item-text="name"
                            item-value="id"
                            :loading="loadingShelf"
                            :class="{ 'is-invalid': editedItem.errors.has('shelf_id') }"
                          ></v-select>
                          <has-error class="red--text" :form="editedItem" field="shelf_id"></has-error>
                        </v-col>
                        <v-col cols="6">
                          <v-autocomplete
                            v-model="editedItem.offer_id"
                            :items="offers"
                            item-text="name"
                            item-value="id"
                            label="Oferta"
                            clearable
                            :loading="loadingOffer"
                            @change="clearOffer"
                            no-data-text="No hay provedores registrados"
                            :class="{ 'is-invalid': editedItem.errors.has('offer_id') }"
                          ></v-autocomplete>
                          <has-error class="red--text" :form="editedItem" field="offer_id"></has-error>
                        </v-col>
                        <v-col cols="6">
                          <v-text-field
                            v-model="editedItem.purchaseprice"
                            label="Precio de compra*"
                            placeholder="_ _ _ _ _ _"
                            v-mask="['######', '######']"
                            required
                            :class="{ 'is-invalid': editedItem.errors.has('purchaseprice') }"
                          ></v-text-field>
                          <has-error class="red--text" :form="editedItem" field="purchaseprice"></has-error>
                        </v-col>
                        <v-col cols="6">
                          <v-text-field
                            v-model="editedItem.saleprice"
                            label="Precio de venta*"
                            placeholder="_ _ _ _ _ _"
                            v-mask="['######', '######']"
                            required
                            :class="{ 'is-invalid': editedItem.errors.has('saleprice') }"
                          ></v-text-field>
                          <has-error class="red--text" :form="editedItem" field="saleprice"></has-error>
                        </v-col>
                        <v-col cols="12">
                          <v-textarea
                            v-model="editedItem.description"
                            auto-grow
                            required
                            label="Descripción*"
                            rows="1"
                            :class="{ 'is-invalid': editedItem.errors.has('description') }"
                          ></v-textarea>
                          <has-error class="red--text" :form="editedItem" field="description"></has-error>
                        </v-col>
                        <v-col cols="12">
                          <v-file-input
                            :rules="rules"
                            type="file"
                            v-model="image"
                            accept="image/png, image/jpeg, image/bmp"
                            placeholder="Pick an avatar"
                            prepend-icon="mdi-camera"
                            @change="onFileChange"
                            label="Avatar"
                          ></v-file-input>
                          <v-img
                            v-if="editedItem.file"
                            :src="editedItem.file"
                            aspect-ratio="2"
                            contain
                          ></v-img>
                        </v-col>
                      </v-row>
                    </v-container>
                  </form>
                  <small>*indicador de campos requeridos</small>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="red darken-1" text @click="close">Cancelar</v-btn>
                  <v-btn
                    color="blue darken-1"
                    :disabled="editedItem.busy"
                    type="submit"
                    text
                    @click="save"
                  >Guardar</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-toolbar>
        </template>
        <template v-slot:item.offer="{ item }">
          <span :class="getColor(item.offer)">{{item.offer!==null?item.offer:'Sin oferta'}}</span>
        </template>
        <template v-slot:item.created_at="{ item }">{{ formatedTime(item.created_at) }}</template>
        <template v-slot:item.updated_at="{ item }">{{ formatedTime(item.updated_at) }}</template>
        <template v-slot:item.actions="{ item }">
          <v-btn color="primary" fab x-small dark @click="editItem(item)">
            <v-icon>mdi-pencil</v-icon>
          </v-btn>
          <v-btn color="red" fab x-small dark @click="deleteItem(item)">
            <v-icon>mdi-delete</v-icon>
          </v-btn>
        </template>
        <template v-slot:no-data>
          <span>Seleccione una subsidiaria para mostrar sus articulos registrados</span>
        </template>
      </v-data-table>
      <!--/v-data-table-->
    </v-card>
  </v-app>
</template>
<script>
export default {
  data: () => ({
    dialogForm: false,
    loading: false,
    loadingSubsidiary: true,
    loadingShelf: true,
    loadingProvider: true,
    loadingOffer: true,
    loadingCategory: true,
    rules: [
      value =>
        !value ||
        value.size < 2000000 ||
        "Avatar size should be less than 2 MB!"
    ],
    headers: [
      { text: "Estante", value: "shelf" },
      { text: "Categoria", value: "category" },
      { text: "Nombre", value: "name" },
      { text: "Proveedor", value: "provider" },
      { text: "Precio de compra", value: "purchaseprice" },
      { text: "Precio de venta", value: "saleprice" },
      { text: "Oferta", value: "offer" },
      { text: "Descripción", value: "description" },
      { text: "Fecha de creación", value: "created_at" },
      { text: "Fecha de modificación", value: "updated_at" },
      { text: "Actions", value: "actions", sortable: false }
    ],
    subsidiaries: [],
    articles: [],
    categories: [],
    shelves: [],
    providers: [],
    offers: [],
    image: null,
    editedIndex: -1,
    subsidiary_selected: "1",
    articleId: "",
    editedItem: new Form({
      category_id: "",
      shelf_id: "",
      provider_id: "",
      offer_id: "",
      name: "",
      purchaseprice: "",
      saleprice: "",
      description: "",
      file: ""
    }),
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo articulo" : "Editar articulo";
    }
  },

  watch: {
    dialogForm(val) {
      val || this.close();
    },
    subsidiary_selected(val) {
      this.articles = [];
      this.shelves = [];
      this.loading = true;
      this.getArticles(val);
      this.getShelves(val);
    }
  },

  created() {
    this.$store.dispatch("can",'articles.index')
    this.initialize()
    this.getCategories()
    this.getProvider()
    this.getOffers()
    
  },

  methods: {
    initialize() {
      axios.get("/api/subsidiaries/list/OnlyName").then(({ data }) => {
        this.subsidiaries = data;
        this.loadingSubsidiary = false;
      });
    },
    editItem(item) {
      (this.editedIndex = { id: item.id }),
        this.editedItem.fill(item),
        (this.dialogForm = true),
        (this.articleId = item.id);
    },
    save() {
      let formData = new FormData();
      formData.append("file", this.image);
      this.setData(formData);
      if (this.editedIndex === -1) {
        let xsrf = this.getCookie("XSRF-TOKEN");
        axios
          .post("/api/articles/store", formData, {
            headers: {
              "Content-Type": "multipart/form-data"
            }
          })
          .then(({ data }) => {
            if (data.status == "200") {
              toastr.success("Registrado con exito");
              this.getArticles(this.subsidiary_selected);
              this.close();
            }
          })
          .catch(error => {
            this.editedItem.errors.set(error.response.data.errors);
            toastr.error("Error al registrar");
          });
      } else {
        let url = `/api/articles/update/${this.articleId}`
        axios
          .post(url, formData, {
            headers: {
              "Content-Type": "multipart/form-data"
            }
          })
          .then(({ data }) => {
            if (data.status == "200") {
              toastr.success("Editado con exito");
              this.getArticles(this.subsidiary_selected);
              this.close();
            }
          })
          .catch(error => {
            this.editedItem.errors.set(error.response.data.errors);
            toastr.error("Error al editar");
          });
      }
    },
    emptyForm() {
      this.editedItem.reset();
      this.image = null;
    },
    deleteItem(item) {
      Swal.fire({
        title: "Estas seguro?",
        text: "No podras revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#007bff",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Eliminar"
      }).then(result => {
        if (result.value) {
          let url = `/api/articles/destroy/${item.id}`;
          const index = this.articles.indexOf(item);
          axios
            .delete(url)
            .then(({ data }) => {
              if (data.status == "200") {
                this.articles.splice(index, 1);
                toastr.success("Eliminado con exito");
              }
            })
            .catch(error => {
              toastr.error("Error al eliminar");
            });
        }
      });
    },

    close() {
      this.dialogForm = false;
      this.$nextTick(() => {
        this.editedIndex = -1;
        this.emptyForm();
      });
    },
    formatedTime(t) {
      return moment(t).format("Do MMM YY");
    },
    getArticles(id) {
      axios.get(`/api/articles/listby/${id}`).then(({ data }) => {
        this.articles = data;
        this.loading = false;
      });
    },
    getShelves(id) {
      axios
        .get(`/api/shelves/list/onlynamebysubsidiary/${id}`)
        .then(({ data }) => {
          this.shelves = data;
          this.loadingShelf = false;
        });
    },
    getCategories() {
      axios.get(`/api/categories/list/onlyname`).then(({ data }) => {
        this.categories = data;
        this.loadingCategory = false;
      });
    },
    getProvider() {
      axios.get(`/api/providers/list/onlyname`).then(({ data }) => {
        this.providers = data;
        this.loadingProvider = false;
      });
    },
    getOffers() {
      axios.get(`/api/offers/`).then(({ data }) => {
        this.offers = data;
        this.loadingOffer = false;
      });
    },
    getColor(status) {
      return status !== null ? "" : "red--text";
    },
    setData(formData) {
      formData.set("category_id", this.editedItem.category_id);
      formData.set("shelf_id", this.editedItem.shelf_id);
      formData.set("provider_id", this.editedItem.provider_id);
      formData.set("offer_id", this.editedItem.offer_id);
      formData.set("name", this.editedItem.name);
      formData.set("purchaseprice", this.editedItem.purchaseprice);
      formData.set("saleprice", this.editedItem.saleprice);
      formData.set("description", this.editedItem.description);
      formData.set("description", this.editedItem.description);
    },
    getCookie(name) {
      // Split cookie string and get all individual name=value pairs in an array
      var cookieArr = document.cookie.split(";");

      // Loop through the array elements
      for (var i = 0; i < cookieArr.length; i++) {
        var cookiePair = cookieArr[i].split("=");

        /* Removing whitespace at the beginning of the cookie name
        and compare it with the given string */
        if (name == cookiePair[0].trim()) {
          // Decode the cookie value and return
          return decodeURIComponent(cookiePair[1]);
        }
      }
      // Return null if not found
      return null;
    },
    onFileChange() {
      if (this.image !== undefined) {
        this.editedItem.file = URL.createObjectURL(this.image);
      } else {
        this.editedItem.file = null;
      }
    },
    clearOffer(){
      if(this.editedItem.offer_id ==undefined){
        this.editedItem.offer_id = ''
      }
    }
  }
};
</script>