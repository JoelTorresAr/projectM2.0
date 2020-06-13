<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" app clipped>
      <v-list dense>
        <v-list-item exact>
          <v-list-item-action>
            <v-icon>mdi-view-dashboard</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Dahsboard</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item exact :to="{name: 'staff'}">
          <v-list-item-action>
            <v-icon>mdi-account</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Personal</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-group no-action prepend-icon="mdi-storefront">
          <template v-slot:activator>
            <v-list-item-title>Productos</v-list-item-title>
          </template>
          <v-list-item exact :to="{name: 'articles'}">
            <v-list-item-title>Productos</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'offers'}">
            <v-list-item-title>Ofertas</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'providers'}">
            <v-list-item-title>Provedores</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'categories'}">
            <v-list-item-title>Categorias</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'igvs'}">
            <v-list-item-title>IGV</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'prooftypes'}">
            <v-list-item-title>Comprobantes</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
        </v-list-group>
        <v-list-group no-action prepend-icon="mdi-account-lock">
          <template v-slot:activator>
            <v-list-item-title>Authenticación</v-list-item-title>
          </template>
          <v-list-item exact :to="{name: 'credentials'}">
            <v-list-item-title>Credenciales</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'roles'}">
            <v-list-item-title>Roles</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'permissions'}">
            <v-list-item-title>Permisos</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
        </v-list-group>
        <v-list-group no-action prepend-icon="mdi-wrench">
          <template v-slot:activator>
            <v-list-item-title>Mantenimiento</v-list-item-title>
          </template>
          <v-list-item exact :to="{name: 'workstations'}">
            <v-list-item-title>Areas de trabajo</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'workpositions'}">
            <v-list-item-title>Puestos de trabajo</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'cities'}">
            <v-list-item-title>Ciudades</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'districts'}">
            <v-list-item-title>Distritos</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'subsidiaries'}">
            <v-list-item-title>Sucursales</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'shelves'}">
            <v-list-item-title>Estantes</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
        </v-list-group>
        <v-list-item link>
          <v-list-item-action>
            <v-icon>mdi-cog</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Settings</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
      <v-spacer></v-spacer>
        <v-list-item @click="changeTheme" align="end">
          <v-list-item-action>
            <v-icon>mdi-brightness-6</v-icon>
          </v-list-item-action>          
          <v-list-item-content>
            <v-list-item-title>Turn on Lights</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item @click="logout" align="end">
          <v-list-item-action>
            <v-icon class="red--text">mdi-power</v-icon>
          </v-list-item-action>          
          <v-list-item-content>
            <v-list-item-title>Cerrar sesión</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
    </v-navigation-drawer>

    <v-app-bar app clipped-left>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>Application</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-chip class="ma-2" color="orange darken-3" outlined>
        <v-icon left>fas fa-key</v-icon>
        Token expira en: {{time}}
      </v-chip>
    </v-app-bar>

    <v-content>
      <v-container class="fill-height" fluid>
        <v-layout class="justify-center">
          <v-flex class="shrink">
            <router-view />
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>

    <v-footer app class="teal--text text--accent-3">
      <v-container fill-height fluid class="justify-center">
        <span>Argus &copy; 2020</span>
      </v-container>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  props: {
    source: String
  },
  data: () => ({
    drawer: null,
    token_expires_in: 0,
    token_timeLeft: 0
  }),
  computed: {
    time: function() {
      return this.token_timeLeft;
    }
  },
  created() {
    this.$vuetify.theme.dark = this.$store.getters.darkStile;
    this.token_expires_in = new Date(localStorage.getItem("token_expires_in"));
    this.countdown();
  },
  mounted: function() {},
  methods: {
    changeTheme() {
      this.$vuetify.theme.dark = !this.$vuetify.theme.dark
    },
    logout() {
      axios.post("/api/dealer/logout").then(({ data }) => {
        if(data.message){
          this.$router.push({ name: "authenticatedealer" });
        }
        console.log(data)
      });
    },
    countdown() {
      var timeLeft = this.token_expires_in - new Date();

      var timeAPI = {
        DAYS: 1000 * 60 * 60 * 24,
        HOURS: 1000 * 60 * 60,
        MINUTES: 1000 * 60,
        SECONDS: 1000
      };

      var tick = function() {
        if (timeLeft > 0) {
          var time = timeLeft;
          var days = Math.floor(time / timeAPI.DAYS);
          time %= timeAPI.DAYS;
          var hours = Math.floor(time / timeAPI.HOURS);
          time %= timeAPI.HOURS;
          var minutes = Math.floor(time / timeAPI.MINUTES);
          time %= timeAPI.MINUTES;
          var seconds = Math.floor(time / timeAPI.SECONDS);
          if (hours < 10) {
            hours = `0${hours}`;
          }
          if (minutes < 10) {
            minutes = `0${minutes}`;
          }
          if (seconds < 10) {
            seconds = `0${seconds}`;
          }

          this.token_timeLeft = `${hours}:${minutes}:${seconds}`;
          if(minutes==10){
            toastr.warning('El token esta por expirar')
          }

          timeLeft -= 1000;
        } else {
          timeLeft -= 1000;
          clearInterval(interval);
          toastr.error("Token vencido");
          this.$router.push({ name: "authenticate" });
          //,onComplete()
        }
      };

      var interval = setInterval(
        (function(self) {
          return function() {
            tick.call(self);
          };
        })(this),
        1000
      );

      tick.call(this);

      return {
        abort: function() {
          clearInterval(interval);
        }
      };
    },
  }
};
</script>