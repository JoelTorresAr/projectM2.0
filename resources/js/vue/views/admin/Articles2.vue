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
                        <v-col cols="12" sm="6">
                          <v-select
                            v-model="editedItem.shelf_id"
                            :items="shelves"
                            label="Stand*"
                            required
                            item-text="name"
                            item-value="id"
                            :class="{ 'is-invalid': editedItem.errors.has('shelf_id') }"
                          ></v-select>
                          <has-error class="red--text" :form="editedItem" field="shelf_id"></has-error>
                        </v-col>
                        <v-col cols="12" sm="6">
                          <v-text-field
                            v-model="editedItem.name"
                            label="Nombre*"
                            required
                            :class="{ 'is-invalid': editedItem.errors.has('name') }"
                          ></v-text-field>
                          <has-error class="red--text" :form="editedItem" field="name"></has-error>
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
                        <v-col>
                          <v-file-input
                            :rules="rules"
                            type="file"
                            v-model="image"
                            accept="image/png, image/jpeg, image/bmp"
                            placeholder="Pick an avatar"
                            prepend-icon="mdi-camera"
                            label="Avatar"
                          ></v-file-input>
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
          <v-btn color="primary" @click="initialize">Reset</v-btn>
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
    loading: true,
    loadingSubsidiary: true,
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
    articles: [],
    subsidiaries: [],
    shelves: [],
    editedIndex: -1,
    subsidiary_selected: "1",
    image: null,
    editedItem: new Form({
      category_id: "1",
      shelf_id: "",
      provider_id: "1",
      offer_id: "1",
      name: "",
      purchaseprice: "15",
      saleprice: "18",
      description: "prueba",
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
      this.getArticles(val);
      this.getShelves(val);
    }
  },

  created() {
  axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
    this.initialize();
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
        (this.editedItem.name = item.name),
        (this.editedItem.description = item.description),
        (this.permissionId = item.id),
        (this.dialogForm = true);
    },
    save() {
      if(this.image!==null){
        console.log(this.image)
        this.editedItem.append('image',this.image);
      }
      if (this.editedIndex === -1) {
        this.editedItem
          .post("/api/articles/store")
          .then(({ data }) => {
            if (data.status == "200") {
              toastr.success("Registrado con exito");
              this.close();
            }
          })
          .catch(error => {
            toastr.error("Error al registrar");
          });
      } else {
        let url = "/api/articles/update/" + this.permissionId;
        this.editedItem
          .put(url)
          .then(({ data }) => {
            if (data.status == "200") {
              toastr.success("Editado con exito");
              this.close();
            }
          })
          .catch(error => {
            toastr.error("Error al editar");
          });
      }
    },
    emptyForm() {
      this.editedItem.reset();
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
          let url = "/api/articles/destroy/" + item.id;
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
        });
    },
    getColor(status) {
      return status !== null ? "" : "red--text";
    },
  }
};
</script>