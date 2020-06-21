<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      app
      :mini-variant.sync="mini"
      permanent
      expand-on-hover
      clipped
    >
      <v-list dense>
        <v-list-item exact :to="{name: 'admin'}" v-if="can('dahsboard.index')">
          <v-list-item-action>
            <v-icon>mdi-view-dashboard</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Dahsboard</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item exact :to="{name: 'staff'}" v-if="can('staff.index')">
          <v-list-item-action>
            <v-icon>mdi-account</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Personal</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-group
          no-action
          v-if="can('articles.index | offers.index | providers.index | categories.index | igvs.index | prooftypes.index')"
          prepend-icon="mdi-storefront"
        >
          <template v-slot:activator>
            <v-list-item-title>Productos</v-list-item-title>
          </template>
          <v-list-item exact :to="{name: 'articles'}" v-if="can('articles.index')">
            <v-list-item-title>Productos</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'offers'}" v-if="can('offers.index')">
            <v-list-item-title>Ofertas</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'providers'}" v-if="can('providers.index')">
            <v-list-item-title>Provedores</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'categories'}" v-if="can('categories.index')">
            <v-list-item-title>Categorias</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'igvs'}" v-if="can('igvs.index')">
            <v-list-item-title>IGV</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'prooftypes'}" v-if="can('prooftypes.index')">
            <v-list-item-title>Comprobantes</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
        </v-list-group>
        <v-list-group
          no-action
          v-if="can('admins.index | roles.index | permissions.index')"
          prepend-icon="mdi-lock-open-variant"
        >
          <template v-slot:activator>
            <v-list-item-title>Authenticación</v-list-item-title>
          </template>
          <v-list-item exact :to="{name: 'credentials'}" v-if="can('admins.index')">
            <v-list-item-title>Credenciales</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'roles'}" v-if="can('roles.index')">
            <v-list-item-title>Roles</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'permissions'}" v-if="can('permissions.index')">
            <v-list-item-title>Permisos</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
        </v-list-group>
        <v-list-group
          no-action
          v-if="can('dealers.index | admins.index')"
          prepend-icon="mdi-account-cash"
        >
          <template v-slot:activator>
            <v-list-item-title>Concesiones</v-list-item-title>
          </template>
          <v-list-item exact :to="{name: 'dealers'}" v-if="can('dealers.index')">
            <v-list-item-title>Empresa</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'roles'}" v-if="can('admins.index')">
            <v-list-item-title>Concesion</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
        </v-list-group>
        <v-list-group
          no-action
          v-if="can('workstations.index | workpositions.index | cities.index | districts.index | subsidiaries.index | shelves.index')"
          prepend-icon="mdi-wrench"
        >
          <template v-slot:activator>
            <v-list-item-title>Mantenimiento</v-list-item-title>
          </template>
          <v-list-item exact :to="{name: 'workstations'}" v-if="can('workstations.index')">
            <v-list-item-title>Areas de trabajo</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'workpositions'}" v-if="can('workpositions.index')">
            <v-list-item-title>Puestos de trabajo</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'cities'}" v-if="can('cities.index')">
            <v-list-item-title>Ciudades</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'districts'}" v-if="can('districts.index')">
            <v-list-item-title>Distritos</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'subsidiaries'}" v-if="can('subsidiaries.index')">
            <v-list-item-title>Sucursales</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'shelves'}" v-if="can('shelves.index')">
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
      <v-list-item @click="changeTheme">
        <v-list-item-action>
          <v-icon>mdi-brightness-6</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Turn on Lights</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-list-item @click="logout">
        <v-list-item-action>
          <v-icon class="red--text">mdi-power</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Cerrar sesión</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-navigation-drawer>

    <v-app-bar app clipped-left>
      <v-app-bar-nav-icon @click.stop="mini = !mini"></v-app-bar-nav-icon>
      <v-toolbar-title>Argus</v-toolbar-title>
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
    drawer: true,
    mini: true,
    idleLifeTime: 0,
    idleStatus: false,
    token_expires_in: 0,
    token_timeLeft: 0
  }),
  onIdle() {
    this.idleStatus = true;
    this.countDownTimerIdle();
  },
  onActive() {
    this.idleStatus = false;
    this.idleLifeTime = process.env.MIX_VUE_IDLE_LIFETIME_MIN * 60;
    this.countDownTimerIdle();
    toastr.warning("Benvenido");
  },
  computed: {
    time: function() {
      return this.token_timeLeft;
    }
  },
  created() {
    this.$vuetify.theme.dark = this.$store.getters.darkStile;
    this.token_expires_in = new Date(localStorage.getItem("token_expires_in"));
    this.countdownToken();
    this.idleLifeTime = process.env.MIX_VUE_IDLE_LIFETIME_MIN * 60;
  },
  mounted: function() {},
  methods: {
    changeTheme() {
      this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
    },
    logout() {
      localStorage.removeItem("roles");
      localStorage.removeItem("permissions");
      axios.post("/api/admin/logout").then(({ data }) => {
        if (data.message) {
          this.$router.push({ name: "authenticate" });
        }
      });
    },
    countdownToken() {
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
          if (hours < 1 && minutes == 10) {
            toastr.warning("El token esta por expirar");
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
    countDownTimerIdle() {
      var tick = function() {
        if (this.idleStatus) {
          if (this.idleLifeTime > 0) {
            toastr.warning(
              `Si no realiza ninguna actividad,la sesión se cerrara automaticamente en ${this.idleLifeTime} seg.`
            );
            this.idleLifeTime -= 1;
          } else {
            this.idleLifeTime -= 1;
            toastr.error("La sesion expiro");
            clearInterval(interval);
            this.logout();
          }
        } else {
          clearInterval(interval);
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
    }
  }
};
</script>