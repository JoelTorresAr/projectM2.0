<template>
  <v-app>
    <v-content>
      <v-container fill-height fluid>
        <v-row align="center" justify="center">
          <v-col cols="12" sm="8" md="8">
            <v-card class="elevation-12">
              <v-row>
                <v-col cols="12" md="8">
                  <v-card-text class="mt-12">
                    <h1 class="text-center display-2 orange--text text--accent-4">Inicio de sesión</h1>
                    <form @submit.prevent="login" class="mt-12">
                      <v-text-field
                        v-model="form.email"
                        label="Usuario*"
                        prepend-icon="mdi-email"
                        type="text"
                        color="orange accent-3"
                        :class="{ 'is-invalid': form.errors.has('email') }"
                        required
                      />
                      <has-error class="red--text" :form="form" field="email"></has-error>
                      <v-text-field
                        v-model="form.password"
                        label="Contraseña*"
                        prepend-icon="mdi-lock"
                        type="password"
                        color="orange accent-3"
                        :class="{ 'is-invalid': form.errors.has('password') }"
                        required
                      />
                      <has-error class="red--text" :form="form" field="password"></has-error>
                    </form>
                    <small>*indicador de campos requeridos</small>
                    <h3 class="text-center mt-3">Olvido su contraseña?</h3>
                  </v-card-text>
                  <div class="text-center mt-3">
                    <v-btn type="submit" @click="login" rounded color="orange accent-3" class="black--text" dark>Ingresar</v-btn>
                  </div>
                </v-col>
                <v-col cols="12" md="4" class="orange accent-4">
                  <v-card-text class="black--text mt-12">
                    <h1 class="text-center display-1">Bienvenido Dealer!</h1>
                    <h5 class="text-center">Ingresa tus datos de administrador para iniciar sesión</h5>
                  </v-card-text>
                </v-col>
              </v-row>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>
<script>
export default {
  data: () => ({
    step: 1,
    form: new Form({
      email: "dealer@hotmail.com",
      password: "secret"
    })
  }),

  props: {
    source: String
  },

  computed: {},

  watch: {},
  created() {
    this.$vuetify.theme.dark = true;
  },
  mounted() {
  },

  methods: {
    login() {
      this.form
        .post("/api/dealer/login")
        .then(res => {
          if (res.data.access_token) {
            toastr.success("Acceso correcto");
            this.$store.commit("SET_TOKEN_EXPIRE_IN", res.data.expires_in);
            this.$store.commit("SET_USER", res.data.user.name)
            this.$router.push({ name: "dealer" });
          }
        })
        .catch(error => {
          toastr.error("Los datos no son validos");
        });
    }
  }
};
</script>