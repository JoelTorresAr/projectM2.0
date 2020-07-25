<template>
  <v-app>
    <v-content>
      <v-container fill-height fluid>
        <v-row align="center" justify="center">
          <v-col cols="12" sm="8" md="8">
            <v-window v-model="step">
              <v-window-item :value="1">
                <v-card class="elevation-12">
                  <v-row>
                    <v-col cols="12" md="8">
                      <v-card-text class="mt-10">
                        <h1
                          class="text-center display-2 orange--text text--accent-4"
                        >Inicio de sesión</h1>
                        <div class="text-center" mt-4>
                          <v-btn class="mx-2" fab color="black" outlined>
                            <v-icon>fab fa-facebook-f</v-icon>
                          </v-btn>
                          <v-btn class="mx-2" fab color="black" outlined>
                            <v-icon>fab fa-google-plus-g</v-icon>
                          </v-btn>
                          <v-btn class="mx-2" fab color="black" outlined>
                            <v-icon>fab fa-linkedin-in</v-icon>
                          </v-btn>
                        </div>
                        <form @submit.prevent="login" class="mt-12">
                          <v-text-field
                            v-model="form.email"
                            label="Correo electronico*"
                            prepend-icon="mdi-email"
                            type="email"
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
                      <div class="text-center mt-3 mb-10">
                        <v-btn
                          type="submit"
                          :disabled="form.busy"
                          @click="login"
                          rounded
                          color="orange accent-3"
                          class="white--text"
                          dark
                        >
                          <strong>Ingresar</strong>
                        </v-btn>
                      </div>
                    </v-col>
                    <v-col cols="12" md="4" class="orange accent-4">
                      <v-card-text class="white--text mt-12">
                        <h1 class="text-center display-1">Bienvenido cliente!</h1>
                        <h5 class="text-center">Ingresa tus datos para iniciar sesión</h5>
                      </v-card-text>
                      <h5 class="text-center white--text">ó</h5>
                      <div class="text-center mb-10">
                        <v-btn
                          type="submit"
                          :disabled="form.busy"
                          @click="step++"
                          rounded
                          outlined
                          dark
                        >
                          <strong>CREA TU CUENTA</strong>
                        </v-btn>
                      </div>
                    </v-col>
                  </v-row>
                </v-card>
              </v-window-item>
              <v-window-item :value="2">
                <v-card class="elevation-12">
                  <v-row>
                    <v-col cols="12" md="4" class="orange accent-4">
                      <v-card-text class="white--text mt-12">
                        <h1 class="text-center display-1">Bienvenido cliente!</h1>
                        <h5 class="text-center">Ingresa tus datos para registrar tu cuenta</h5>
                      </v-card-text>
                      <h5 class="text-center white--text">ó</h5>
                      <div class="text-center mb-10">
                        <v-btn
                          type="submit"
                          :disabled="form.busy"
                          @click="step--"
                          rounded
                          outlined
                          dark
                        >
                          <strong>INICIA SESIÓN</strong>
                        </v-btn>
                      </div>
                    </v-col>
                    <v-col cols="12" md="8">
                      <v-card-text class="mt-10">
                        <h1
                          class="text-center display-2 orange--text text--accent-4"
                        >Registro de datos</h1>
                        <form @submit.prevent="login" class="mt-12">
                          <v-row>
                            <v-col cols="12">
                              <v-text-field
                                v-model="form.name"
                                label="Nombre de usuario*"
                                prepend-icon="mdi-account"
                                type="text"
                                color="orange accent-3"
                                :class="{ 'is-invalid': form.errors.has('name') }"
                                required
                              />
                              <has-error class="red--text" :form="form" field="name"></has-error>
                            </v-col>
                            <v-col cols="12">
                              <v-text-field
                                v-model="form.email"
                                label="Nombre de usuario*"
                                prepend-icon="mdi-email"
                                type="text"
                                color="orange accent-3"
                                :class="{ 'is-invalid': form.errors.has('email') }"
                                required
                              />
                              <has-error class="red--text" :form="form" field="email"></has-error>
                            </v-col>
                            <v-col cols="12">
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
                            </v-col>
                            <v-col cols="12">
                              <v-text-field
                                v-model="form.password_confirmation"
                                label="Confirmación de contraseña*"
                                prepend-icon="mdi-lock"
                                type="password"
                                color="orange accent-3"
                                :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
                                required
                              />
                              <has-error class="red--text" :form="form" field="password"></has-error>
                            </v-col>
                          </v-row>
                        </form>
                        <small>*indicador de campos requeridos</small>
                      </v-card-text>
                      <div class="text-center mt-3 mb-10">
                        <v-btn
                          type="submit"
                          :disabled="form.busy"
                          @click="register"
                          rounded
                          color="orange accent-3"
                          class="black--text"
                          dark
                        >Registrar</v-btn>
                      </div>
                    </v-col>
                  </v-row>
                </v-card>
              </v-window-item>
            </v-window>
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
      name: "",
      email: "",
      password: "",
      password_confirmation: ""
    })
  }),

  props: {
    source: String
  },

  computed: {},

  watch: {},
  created() {
    this.$vuetify.theme.dark = false;
  },
  mounted() {},

  methods: {
    login() {
      this.form
        .post("/api/user/login")
        .then(res => {
          if (res.data.access_token) {
            toastr.success("Acceso correcto");
            this.$store.commit("SET_TOKEN_EXPIRE_IN", res.data.expires_in);
            this.$store.commit("SET_USER", res.data.user.name);
            window.history.length > 1
              ? this.$router.go(-1)
              : this.$router.push({ name: "indexstore" });
            // this.$router.go({ name: "sales" })
            //location.reload();
          }
        })
        .catch(error => {
          toastr.error("Los datos no son validos");
        });
    },
    register() {
      this.form
        .post("/api/user/register")
        .then(res => {
          if (res.data.access_token) {
            toastr.success("Registrado con exito");
            this.$store.commit("SET_TOKEN_EXPIRE_IN", res.data.expires_in);
            this.$store.commit("SET_USER", res.data.user.name);
            window.history.length > 1
              ? this.$router.go(-1)
              : this.$router.push({ name: "indexstore" });
            // this.$router.go({ name: "sales" })
            //location.reload();
          }
        })
        .catch(error => {
          toastr.error("Los datos no son validos");
        });
    }
  }
};
</script>