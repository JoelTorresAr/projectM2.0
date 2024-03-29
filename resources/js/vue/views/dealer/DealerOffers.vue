<template>
  <v-app id="app">
    <v-data-table
      :headers="headers"
      :items="offers"
      item-key="id"
      sort-by="name"
      class="elevation-1"
      :loading="loading"
      loading-text="Cargando... Por favor espere"
    >
      <template v-slot:top>
        <v-toolbar flat class="mt-2">
          <v-toolbar-title>Ofertas</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
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
                      <v-col cols="12" md="6">
                        <v-text-field
                          v-model="editedItem.name"
                          label="Nombre*"
                          required
                          :class="{ 'is-invalid': editedItem.errors.has('name') }"
                        ></v-text-field>
                        <has-error class="red--text" :form="editedItem" field="name"></has-error>
                      </v-col>
                      <v-col cols="12" md="6">
                        <v-text-field
                          v-model="editedItem.discount"
                          label="% de descuento*"
                          type="numeric"
                          required
                          :class="{ 'is-invalid': editedItem.errors.has('discount') }"
                        ></v-text-field>
                        <has-error class="red--text" :form="editedItem" field="discount"></has-error>
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
      <template v-slot:item.discount="{ item }">{{ item.discount }} %</template>
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
  </v-app>
</template>
<script>
export default {
  data: () => ({
    dialogForm: false,
    loading: true,
    headers: [
      { text: "Nombre", value: "name" },
      { text: "% de descuento", value: "discount" },
      { text: "Fecha de creación", value: "created_at" },
      { text: "Fecha de modificación", value: "updated_at" },
      { text: "", value: "actions", sortable: false }
    ],
    offers: [],
    editedIndex: -1,
    itemSelectedId: "",
    editedItem: new Form({
      name: "",
      discount: ""
    })
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nueva oferta" : "Editar oferta";
    },
  },

  watch: {
    dialogForm(val) {
      val || this.close();
    }
  },
  beforeCreate() {
    
  },

  created() {
    this.initialize();
  },

  methods: {
    initialize() {
      axios.get("/api/offers").then(({ data }) => {
        this.offers = data;
        this.loading = false;
      });
    },
    editItem(item) {
      (this.editedIndex = { id: item.id }),
        (this.editedItem.name = item.name),
        (this.editedItem.discount = item.discount),
        (this.itemSelectedId = item.id),
        (this.dialogForm = true);
    },
    save() {
      if (this.editedIndex === -1) {
        this.editedItem
          .post("/api/offers/store")
          .then(({ data }) => {
            if (data.status == "200") {
              this.initialize();
              toastr.success("Registrado con exito");
              this.close();
            }
          })
          .catch(error => {
            toastr.error("Error al registrar");
          });
      } else {
        let url = "/api/offers/update/" + this.itemSelectedId;
        this.editedItem
          .put(url)
          .then(({ data }) => {
            if (data.status == "200") {
              this.initialize();
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
      this.editedItem.reset()
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
          let url = "/api/offers/destroy/" + item.id;
          const index = this.offers.indexOf(item);
          axios
            .delete(url)
            .then(({ data }) => {
              if (data.status == "200") {
                this.offers.splice(index, 1);
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
    }
  }
};
</script>