<template>
  <v-app id="app">
    <v-card>
      <v-card-title>
        Concesiones
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-autocomplete
          v-model="dealer_selected"
          :items="dealers"
          append-icon="mdi-magnify"
          item-text="name"
          item-value="id"
          label="Dealer"
          :loading="loadingDealer"
          no-data-text="No hay dealers registrados"
          hint="*Selecciona un dealer para cargar sus concesiones"
          persistent-hint
        ></v-autocomplete>
      </v-card-title>
      <v-data-table
        :headers="headers"
        :items="concessions"
        item-key="id"
        sort-by="name"
        class="elevation-2"
        :loading="loading"
        loading-text="Cargando... Por favor espere"
      >
        <template v-slot:top>
          <v-toolbar flat class="mt-2">
            <v-spacer></v-spacer>
            <v-dialog v-model="dialogForm" persistent max-width="600px">
              <template v-slot:activator="{ on }" v-if="can('dealers.create')">
                <v-btn
                  color="primary"
                  class="mb-2"
                  dark
                  v-on="on"
                  :disabled="buttonDisable"
                >Agregar nuevo</v-btn>
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
                            v-model="subsidiary_id"
                            :items="subsidiaries"
                            label="Sucursal*"
                            required
                            item-text="name"
                            item-value="id"
                            :loading="loadingSubsidiary"
                            :class="{ 'is-invalid': editedItem.errors.has('subsidiary_id') }"
                          ></v-select>
                          <has-error class="red--text" :form="editedItem" field="subsidiary_id"></has-error>
                        </v-col>
                        <v-col cols="12" md="6">
                          <v-select
                            v-model="editedItem.shelf_id"
                            :items="shelves"
                            label="Estante*"
                            required
                            item-text="name"
                            item-value="id"
                            :loading="loadingShelves"
                            :class="{ 'is-invalid': editedItem.errors.has('shelf_id') }"
                          ></v-select>
                          <has-error class="red--text" :form="editedItem" field="shelf_id"></has-error>
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
        <template v-slot:item.updated_at="{ item }">{{ formatedTime(item.updated_at) }}</template>
        <template v-slot:item.actions="{ item }">
          <v-btn
            color="red"
            fab
            x-small
            dark
            @click="deleteItem(item)"
            v-if="can('dealers.destroy')"
          >
            <v-icon>mdi-delete</v-icon>
          </v-btn>
        </template>
        <template v-slot:no-data>
          <span class="red--text">No tiene concesiones registradas</span>
        </template>
      </v-data-table>
      <!--/v-data-table-->
    </v-card>
  </v-app>
</template>
<script>
//import moment from 'moment'

export default {
  data: () => ({
    dialogForm: false,
    dialogStaff: false,
    buttonDisable: true,
    loading: false,
    loadingDealer: true,
    loadingSubsidiary: true,
    loadingShelves: true,
    headers: [
      { text: "Nombre", value: "name", align: "center" },
      { text: "Subsidiaria", value: "subsidiary", align: "center" },
      { text: "Fecha de modificación", value: "updated_at", align: "center" },
      { text: "", value: "actions", sortable: false }
    ],
    dealers: [],
    concessions: [],
    shelves: [],
    subsidiaries: [],
    editedIndex: -1,
    itemId: "",
    dealer_selected: "",
    subsidiary_id: "",
    editedItem: new Form({
      shelf_id: ""
    })
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nueva concesion" : "Editar concesion";
    }
  },

  watch: {
    dialogForm(val) {
      val || this.close();
    },
    dealer_selected(val) {
      this.getConcessions(val);
    },
    subsidiary_id(val) {
      this.loadingShelves = true;
      this.shelves = [];
      axios.get(`/api/concessions/list/shelves/${val}`).then(({ data }) => {
        this.shelves = data;
        this.loadingShelves = false;
      });
    }
  },
  beforeCreate() {},

  created() {
    this.$store.dispatch("can", "dealers.index");
    this.initialize();
  },

  methods: {
    initialize() {
      axios.get("/api/dealers/list/onlyname").then(({ data }) => {
        this.dealers = data;
        this.loadingDealer = false;
      });
      axios.get("/api/subsidiaries/list/onlyname").then(({ data }) => {
        this.subsidiaries = data;
        this.loadingSubsidiary = false;
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
          let url = "/api/concessions/destroy/" + item.id;
          const index = this.concessions.indexOf(item);
          axios
            .delete(url)
            .then(({ data }) => {
              if (data.status == "200") {
                this.concessions.splice(index, 1);
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
          .post(`/api/concessions/store/${this.dealer_selected}`)
          .then(({ data }) => {
            if (data.status == "200") {
              this.getConcessions(this.dealer_selected);
              toastr.success("Registrado con exito");
              this.close();
            }
          })
          .catch(error => {
            toastr.error("Error al registrar");
          });
      }
    },
    emptyForm() {
      this.editedItem.reset();
    },
    formatedTime(t) {
      return moment(t).format("Do MMM YY");
    },
    getConcessions(dealer) {
      this.buttonDisable = false;
      axios.get(`/api/shelves/list/bydealer/${dealer}`).then(({ data }) => {
        this.concessions = [];
        this.concessions = data;
        this.loading = false;
      });
    }
  }
};
</script>