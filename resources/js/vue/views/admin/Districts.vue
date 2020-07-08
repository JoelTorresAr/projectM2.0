<template>
  <v-app id="app">
    <v-data-table
      :headers="headers"
      :items="districts"
      item-key="id"
      sort-by="name"
      class="elevation-1"
      :loading="loading"
      loading-text="Cargando... Por favor espere"
    >
      <template v-slot:top>
        <v-toolbar flat class="mt-2">
          <v-toolbar-title>Distritos</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialogForm" persistent max-width="600px">
            <template v-slot:activator="{ on }" v-if="can('districts.create')">
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
                        <v-select
                          v-model="editedItem.city_id"
                          :items="cities"
                          label="Ciudad*"
                          required
                          item-text="name"
                          item-value="id"
                          :class="{ 'is-invalid': editedItem.errors.has('city_id') }"
                        ></v-select>
                        <has-error class="red--text" :form="editedItem" field="city_id"></has-error>
                      </v-col>
                      <v-col cols="12">
                        <v-text-field
                          v-model="editedItem.name"
                          label="Nombre*"
                          required
                          :class="{ 'is-invalid': editedItem.errors.has('name') }"
                        ></v-text-field>
                        <has-error class="red--text" :form="editedItem" field="name"></has-error>
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
      <template v-slot:item.created_at="{ item }">{{ formatedTime(item.created_at) }}</template>
      <template v-slot:item.updated_at="{ item }">{{ formatedTime(item.updated_at) }}</template>
      <template v-slot:item.actions="{ item }">
        <v-btn color="primary" fab x-small dark @click="editItem(item)" v-if="can('districts.edit')">
          <v-icon>mdi-pencil</v-icon>
        </v-btn>
        <v-btn color="red" fab x-small dark @click="deleteItem(item)" v-if="can('districts.destroy')">
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
      { text: "Ciudad", value: "city" },
      { text: "Fecha de creación", value: "created_at" },
      { text: "Fecha de modificación", value: "updated_at" },
      { text: "", value: "actions", sortable: false }
    ],
    districts: [],
    cities: [],
    editedIndex: -1,
    itemSelectedId: "",
    editedItem: new Form({
      name: "",
      city_id: ""
    })
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo distrito" : "Editar distrito";
    }
  },

  watch: {
    dialogForm(val) {
      val || this.close();
    }
  },
  beforeCreate() {
    
  },

  created() {
    this.$store.dispatch("can", "cities.index");
    this.initialize();
    this.getcities();
  },

  methods: {
    initialize() {
      axios.get("/api/districts").then(({ data }) => {
        this.districts = data;
        this.loading = false;
      });
    },
    editItem(item) {
      (this.editedIndex = { id: item.id }),
        (this.editedItem.name = item.name),
        (this.editedItem.city_id = item.city_id),
        (this.itemSelectedId = item.id),
        (this.dialogForm = true);
    },
    save() {
      if (this.editedIndex === -1) {
        this.editedItem
          .post("/api/districts/store")
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
        let url = "/api/districts/update/" + this.itemSelectedId;
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
          let url = "/api/districts/destroy/" + item.id;
          const index = this.districts.indexOf(item);
          axios
            .delete(url)
            .then(({ data }) => {
              if (data.status == "200") {
                this.districts.splice(index, 1);
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
    getcities() {
      let url = "/api/cities";
      axios.get(url).then(({ data }) => (this.cities = data));
    }
  }
};
</script>