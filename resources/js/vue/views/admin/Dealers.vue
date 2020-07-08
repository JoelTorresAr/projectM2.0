<template>
  <v-app id="app">
    <v-data-table
      :headers="headers"
      :items="dealers"
      item-key="id"
      sort-by="staff_id"
      class="elevation-1"
      :loading="loading"
      loading-text="Cargando... Por favor espere"
    >
      <template v-slot:top>
        <v-toolbar flat class="mt-2">
          <v-toolbar-title>Empresas</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialogForm" persistent max-width="600px">
            <template v-slot:activator="{ on }" v-if="can('dealers.create')">
              <v-btn color="primary" class="mb-2" dark v-on="on">Agregar nuevo</v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">{{ formTitle }}</span>
              </v-card-title>
              <v-card-text>
                <form @submit.prevent="save">
                  <v-container>
                    <v-row>
                      <v-col cols="12" sm="9">
                        <v-text-field
                          v-model="editedItem.name"
                          label="Nombre*"
                          required
                          :class="{ 'is-invalid': editedItem.errors.has('name') }"
                        ></v-text-field>
                        <has-error class="red--text" :form="editedItem" field="name"></has-error>
                      </v-col>
                      <v-col cols="12" sm="3">
                        <v-switch
                          v-model="editedItem.active"
                          label="Estado"
                          required
                          :hint="editedItem.active?'Activo':'Inactivo'" 
                          persistent-hint
                          :class="{ 'is-invalid': editedItem.errors.has('active') }"
                        ></v-switch>
                        <has-error class="red--text" :form="editedItem" field="active"></has-error>
                      </v-col>
                      <v-col cols="12">
                        <v-text-field
                          v-model="editedItem.email"
                          label="Correo*"
                          required
                          :class="{ 'is-invalid': editedItem.errors.has('email') }"
                        ></v-text-field>
                        <has-error class="red--text" :form="editedItem" field="email"></has-error>
                      </v-col>
                      <v-col cols="12" sm="6">
                        <v-text-field
                          v-model="editedItem.password"
                          label="Contraseña*"
                          type="password"
                          required
                          :class="{ 'is-invalid': editedItem.errors.has('password') }"
                        ></v-text-field>
                        <has-error class="red--text" :form="editedItem" field="password"></has-error>
                      </v-col>
                      <v-col cols="12" sm="6">
                        <v-text-field
                          v-model="editedItem.password_confirmation"
                          label="Confirmación de contraseña*"
                          type="password"
                          required
                          :class="{ 'is-invalid': editedItem.errors.has('password_confirmation') }"
                        ></v-text-field>
                        <has-error
                          class="red--text"
                          :form="editedItem"
                          field="password_confirmation"
                        ></has-error>
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
      <template v-slot:item.active="{ item }">
        <span :class="getColor(item.active)">{{item.active!==false?'Habilitado':'Deshabilitado'}}</span>
      </template>
      <template v-slot:item.created_at="{ item }">{{ formatedTime(item.created_at) }}</template>
      <template v-slot:item.updated_at="{ item }">{{ formatedTime(item.updated_at) }}</template>
      <template v-slot:item.actions="{ item }">
        <v-btn color="primary" fab x-small dark @click="editItem(item)" v-if="can('dealers.edit')">
          <v-icon>mdi-pencil</v-icon>
        </v-btn>
        <v-btn color="red" fab x-small dark @click="deleteItem(item)" v-if="can('dealers.destroy')">
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
//import moment from 'moment'

export default {
  data: () => ({
    dialogForm: false,
    dialogStaff: false,
    loading: true,
    headers: [
      { text: "Nombre", value: "name", align: "center" },
      { text: "Correo", value: "email", align: "center" },
      { text: "Estado", value: "active", align: "center" },
      { text: "Fecha de creación", value: "created_at", align: "center" },
      { text: "Fecha de modificación", value: "updated_at", align: "center" },
      { text: "", value: "actions", sortable: false }
    ],
    dealers: [],
    editedIndex: -1,
    itemId: "",
    editedItem: new Form({
      name: "",
      email: "",
      password: "",
      active: true,
      password_confirmation: ""
    })
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo dealers" : "Editar dealers";
    }
  },

  watch: {
    dialogForm(val) {
      val || this.close();
    }
  },
  beforeCreate() {},

  created() {
    this.$store.dispatch("can", "dealers.index");
    this.initialize();
  },

  methods: {
    initialize() {
      axios.get("/api/dealers").then(({ data }) => {
        this.dealers = data;
        this.loading = false;
      });
    },
    editItem(item) {
      this.editedIndex = { id: item.id };
      this.editedItem.fill(item);
      this.itemId = item.id;
      this.dialogForm = true;
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
          let url = "/api/dealers/destroy/" + item.id;
          const index = this.dealers.indexOf(item);
          axios
            .delete(url)
            .then(({ data }) => {
              if (data.status == "200") {
                this.dealers.splice(index, 1);
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
    save() {
      if (this.editedIndex === -1) {
        this.editedItem
          .post("/api/dealers/store")
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
        let url = `/api/dealers/update/${this.itemId}`;
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
    getColor(status) {
      return status !== false ? "" : "red--text";
    },
    formatedTime(t) {
      return moment(t).format("Do MMM YY");
    }
  }
};
</script>