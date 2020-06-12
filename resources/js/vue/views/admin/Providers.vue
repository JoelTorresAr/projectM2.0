<template>
  <v-app id="app">
    <v-data-table
      :headers="headers"
      :items="providers"
      :dark="darkStile"
      item-key="id"
      sort-by="subsidiary"
      class="elevation-1"
      :loading="loading"
      loading-text="Cargando... Por favor espere"
    >
      <template v-slot:top>
        <v-toolbar flat class="mt-2">
          <v-toolbar-title>Proveedores</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-dialog :dark="darkStile" v-model="dialogForm" persistent max-width="600px">
            <template v-slot:activator="{ on }">
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
                      <v-col cols="12">
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
                          label="Celular*"
                          v-model="editedItem.phone1"
                          type="tel"
                          placeholder="(+51) _ _ _ - _ _ _ - _ _ _"
                          v-mask="['(+51) ###-###-###', '(+51) ###-###-###']"
                          required
                          :class="{ 'is-invalid': editedItem.errors.has('phone1') }"
                        ></v-text-field>
                        <has-error class="red--text" :form="editedItem" field="phone1"></has-error>
                      </v-col>
                      <v-col cols="12" md="6">
                        <v-text-field
                          label="R.U.C.*"
                          v-model="editedItem.ruc"
                          type="numeric"
                          placeholder="_ _ _ _ _ _ _ _ _ _ _"
                          v-mask="['###########', '###########']"
                          required
                          :class="{ 'is-invalid': editedItem.errors.has('ruc') }"
                        ></v-text-field>
                        <has-error class="red--text" :form="editedItem" field="ruc"></has-error>
                      </v-col>
                      <v-col cols="12">
                        <v-text-field
                          v-model="editedItem.address"
                          label="Dirección*"
                          required
                          :class="{ 'is-invalid': editedItem.errors.has('address') }"
                        ></v-text-field>
                        <has-error class="red--text" :form="editedItem" field="address"></has-error>
                      </v-col>
                      <v-col cols="12" sm="6">
                        <v-select
                          v-model="citySelected"
                          :items="cities"
                          label="Ciudad"
                          required
                          item-text="name"
                          item-value="id"
                          @change="getDistrictsbyCity()"
                        ></v-select>
                      </v-col>
                      <v-col cols="12" sm="6">
                        <v-select
                          v-model="editedItem.district_id"
                          :items="districts"
                          label="Distrito*"
                          required
                          item-text="name"
                          item-value="id"
                          :class="{ 'is-invalid': editedItem.errors.has('district_id') }"
                        ></v-select>
                        <has-error class="red--text" :form="editedItem" field="district_id"></has-error>
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
      { text: "Ciudad", value: "city" },
      { text: "R.U.C.", value: "ruc" },
      { text: "Telefono", value: "phone1" },
      { text: "Actions", value: "actions", sortable: false }
    ],
    providers: [],
    cities: [],
    districts: [],
    citySelected: "",
    editedIndex: -1,
    itemSelectedId: "",
    editedItem: new Form({
      district_id: "",
      address: "",
      address2: "",
      ruc: "",
      name: "",
      phone1: "",
      phone2: ""
    })
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo proveedor" : "Editar proveedor";
    },
    darkStile(){
      return this.$store.getters.darkStile;
    }
  },

  watch: {
    dialogForm(val) {
      val || this.close();
    }
  },

  created() {
    this.initialize();
    this.getCities();
  },

  methods: {
    initialize() {
      axios.get("/api/providers").then(({data}) => {
        this.providers = data;
        this.loading = false;
      });
    },
    editItem(item) {
      (this.editedIndex = { id: item.id }),
      (this.citySelected = item.city_id),
      (this.getDistrictsbyCity(this.citySelected)),
      (this.editedItem.name = item.name),
      (this.editedItem.address = item.address),
      (this.editedItem.ruc = item.ruc),
      (this.editedItem.phone1 = item.phone1),
      (this.editedItem.district_id = item.district_id),
      (this.itemSelectedId = item.id),
      (this.dialogForm = true);
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
          let url = "/api/providers/destroy/" + item.id;
          const index = this.providers.indexOf(item);
          axios
              .delete(url)
              .then(({ data }) => {
                if (data.status == "200") {
                  this.providers.splice(index, 1);
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
          this.editedItem.post("/api/providers/store").then(({ data }) => {
          console.log(data);
          if (data.status == "200") {
              this.initialize();
              toastr.success("Registrado con exito");
              this.close();
            }
          })
          .catch(error => {
            toastr.error("Error al editar");
          });
      } else {
        let url = "/api/providers/update/" + this.itemSelectedId;
        this.editedItem.put(url).then(({ data }) => {
          if (data.status == "200") {
              this.initialize();
              toastr.success("Editado con exito");
              this.close();
            }
          })
          .catch(error => {
            toastr.error("Error al registrar");
          });
        
      }
    },
    emptyForm() {
      (this.citySelected = "");
      (this.editedItem.name = "");
      (this.editedItem.address = "");
      (this.editedItem.ruc = "");
      (this.editedItem.phone1 = "");
      (this.editedItem.district_id = "");
      (this.itemSelectedId = "");
    },
    getCities() {
      let url = "/api/cities";
      axios.get(url).then(({ data }) => (this.cities = data));
    },
    getDistrictsbyCity($id = this.citySelected) {
      let url = "/api/districts/showbycity/" + $id;
      axios.get(url).then(response => {
        if (response.data.length > 0) {
          this.districts = response.data;
          //this.editedItem.district_id = this.districts[0].id;
        } else {
          this.districts = [];
          this.editedItem.district_id = "";
        }
      });
    },
  }
};
</script>