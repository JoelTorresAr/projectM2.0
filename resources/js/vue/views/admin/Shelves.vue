<template>
  <v-app id="app">
    <v-data-table
      :headers="headers"
      :items="shelves"
      item-key="id"
      :sort-by="['subsidiary', 'name','rentalstatus']"
      :sort-desc="[true, true,true]"
      multi-sort
      class="elevation-1"
      :loading="loading"
      loading-text="Cargando... Por favor espere"
    >
      <template v-slot:top>
        <v-toolbar flat class="mt-2">
          <v-toolbar-title>Estantes</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialogForm" persistent max-width="600px">
            <template v-slot:activator="{ on }" v-if="can('shelves.create')">
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
                        <v-select
                          v-model="editedItem.subsidiary_id"
                          :items="subsidiaries"
                          label="Sucursal*"
                          required
                          item-text="name"
                          item-value="id"
                          :class="{ 'is-invalid': editedItem.errors.has('subsidiary_id') }"
                        ></v-select>
                        <has-error class="red--text" :form="editedItem" field="subsidiary_id"></has-error>
                      </v-col>
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
                        <v-select
                          v-model="editedItem.rentalstatus"
                          :items="rentalstatus"
                          attach
                          label="Estado de renta"
                        ></v-select>
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
      <template v-slot:item.rentalstatus="{ item }">
        <v-chip
          :color="getColor(item.dealer_id)"
          dark
        >{{ item.dealer_id !== null ? "Concecionado" : "Sin concecion"}}</v-chip>
      </template>
      <template v-slot:item.created_at="{ item }">{{ formatedTime(item.created_at) }}</template>
      <template v-slot:item.updated_at="{ item }">{{ formatedTime(item.updated_at) }}</template>
      <template v-slot:item.actions="{ item }">
        <v-btn color="primary" fab x-small dark @click="editItem(item)" v-if="can('shelves.edit')">
          <v-icon>mdi-pencil</v-icon>
        </v-btn>
        <v-btn color="red" fab x-small dark @click="deleteItem(item)" v-if="can('shelves.destroy')">
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
      { text: "Sucursal", value: "subsidiary" },
      { text: "Estado", value: "rentalstatus" },
      { text: "Consesionario", value: "dealer" },
      { text: "Fecha de creación", value: "created_at" },
      { text: "Fecha de modificación", value: "updated_at" },
      { text: "", value: "actions", sortable: false }
    ],
    rentalstatus: ["ENABLE", "DISABLE"],
    shelves: [],
    subsidiaries: [],
    editedIndex: -1,
    itemSelectedId: "",
    editedItem: new Form({
      name: "",
      subsidiary_id: "",
      rentalstatus: "ENABLE",
      dealer_id: ""
    })
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo estante" : "Editar estante";
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
    this.$store.dispatch("can", "shelves.index");
    this.initialize();
    this.getsubsidiaries();
  },

  methods: {
    initialize() {
      axios.get("/api/shelves").then(({ data }) => {
        this.shelves = data;
        this.loading = false;
      });
    },
    editItem(item) {
      (this.editedIndex = { id: item.id }),
        (this.editedItem.name = item.name),
        (this.editedItem.subsidiary_id = item.subsidiary_id),
        (this.editedItem.rentalstatus = item.rentalstatus),
        (this.editedItem.dealer_id = item.dealer_id),
        (this.itemSelectedId = item.id),
        (this.dialogForm = true);
    },
    save() {
      if (this.editedIndex === -1) {
        this.editedItem
          .post("/api/shelves/store")
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
        let url = "/api/shelves/update/" + this.itemSelectedId;
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
          let url = "/api/shelves/destroy/" + item.id;
          const index = this.shelves.indexOf(item);
          axios
            .delete(url)
            .then(({ data }) => {
              if (data.status == "200") {
                this.shelves.splice(index, 1);
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
    getsubsidiaries() {
      let url = "/api/subsidiaries";
      axios.get(url).then(({ data }) => (this.subsidiaries = data));
    },
    getColor(status) {
      return status !== null ? "green" : "red";
    }
  }
};
</script>