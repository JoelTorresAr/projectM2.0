<template>
  <v-app id="app">
    <v-data-table
      :headers="headers"
      :items="roles"
      item-key="id"
      sort-by="name"
      class="elevation-1"
      :loading="loading"
      loading-text="Cargando... Por favor espere"
      :single-expand="singleExpand"
      :expanded.sync="expanded"
      expanded.flat="true"
      show-expand
    >
      <template v-slot:top>
        <v-toolbar flat class="mt-2">
          <v-toolbar-title>Roles</v-toolbar-title>
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
                      <v-col cols="12">
                        <v-text-field
                          v-model="editedItem.name"
                          label="Nombre*"
                          required
                          :class="{ 'is-invalid': editedItem.errors.has('name') }"
                        ></v-text-field>
                        <has-error class="red--text" :form="editedItem" field="name"></has-error>
                      </v-col>
                      <v-col cols="12">
                        <v-autocomplete
                          v-model="editedItem.permissions"
                          :items="permissions"
                          item-text="name"
                          item-value="id"
                          clearable
                          dense
                          chips
                          small-chips
                          label="Permisos"
                          multiple
                        >
                          <template v-slot:selection="{attrs, item, select, selected, index }">
                            <v-chip
                              v-bind="attrs"
                              :input-value="selected"
                              close
                              @click="select"
                              @click:close="remove(item)"
                              v-if="index < 2"
                            >
                              <span>{{ item.name }}</span>
                            </v-chip>
                            <span
                              v-if="index === 2"
                              class="grey--text caption"
                            >(+{{ editedItem.permissions.length - 2 }} otros)</span>
                          </template>
                        </v-autocomplete>
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
      <template v-slot:expanded-item="{ headers, item }">
        <td :colspan="headers.length">
          <strong>Permisos:</strong>
          <v-list-item>
            <v-list-item-content>
              <v-row>
                <v-col
                  cols="3"
                  class="text-left"
                  v-for="(permission, index) in item.permissions"
                  :key="index"
                >
                  <v-list-item-title>
                    <li>{{permission.name}}</li>
                  </v-list-item-title>
                </v-col>
                <v-col cols="12" class="text-left" v-if="item.permissions.length==0">
                  <strong>No tiene permisos asignados</strong>
                </v-col>
              </v-row>
            </v-list-item-content>
          </v-list-item>
        </td>
      </template>
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
      { text: "Fecha de creación", value: "created_at" },
      { text: "Fecha de modificación", value: "updated_at" },
      { text: "Descripción", value: "description" },
      { text: "Actions", value: "actions", sortable: false },
      { text: "Permisos", value: "data-table-expand" }
    ],
    roles: [],
    permissions: [],
    expanded: [],
    singleExpand: false,
    editedIndex: -1,
    rolId: "",
    editedItem: new Form({
      name: "",
      description: "",
      permissions: []
    })
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo rol" : "Editar rol";
    },
  },

  watch: {
    dialogForm(val) {
      val || this.close();
    }
  },

  created() {
    this.initialize();
    this.getPermissions();
  },

  methods: {
    initialize() {
      axios.get("/api/roles").then(response => {
        this.roles = response.data;
        this.loading = false;
      });
    },
    editItem(item) {
      (this.editedIndex = { id: item.id }),
        (this.editedItem.name = item.name),
        (this.editedItem.description = item.description),
        (this.rolId = item.id),
        (this.dialogForm = true),
        (this.editedItem.permissions = []);
      for (var i = 0; i < item.permissions.length; i++) {
        this.editedItem.permissions.push(item.permissions[i].id);
      }
    },
    save() {
      if (this.editedIndex === -1) {
        this.editedItem
          .post("/api/roles/store")
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
        let url = "/api/roles/update/" + this.rolId;
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
      (this.editedItem.name = ""),
        (this.editedItem.description = ""),
        (this.editedItem.permissions = []);
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
          let url = "/api/roles/destroy/" + item.id;
          const index = this.roles.indexOf(item);
          axios
            .delete(url)
            .then(({ data }) => {
              if (data.status == "200") {
                this.roles.splice(index, 1);
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
    remove(item) {
      this.editedItem.permissions.splice(
        this.editedItem.permissions.indexOf(item),
        1
      );
      this.editedItem.permissions = [...this.editedItem.permissions];
    },
    getPermissions() {
      axios.get("/api/permissions/list/OnlyName").then(({ data }) => {
        this.permissions = data;
      });
    },
    formatedTime(t) {
      return moment(t).format("Do MMM YY");
    }
  }
};
</script>