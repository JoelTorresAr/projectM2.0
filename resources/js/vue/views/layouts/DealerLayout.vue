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
        <v-list-item two-line class="miniVariant && 'px-0'">
          <v-list-item-avatar>
            <img src="/images/argus2.svg" />
          </v-list-item-avatar>

          <v-list-item-content>
            <v-list-item-title>{{user}}</v-list-item-title>
            <v-list-item-subtitle>Dealer</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
        <v-list-item exact :to="{name: 'admin'}">
          <v-list-item-action>
            <v-icon>mdi-view-dashboard</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Dahsboard</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-group no-action prepend-icon="mdi-storefront">
          <template v-slot:activator>
            <v-list-item-title>Almacen</v-list-item-title>
          </template>
          <v-list-item exact :to="{name: 'dealerarticles'}">
            <v-list-item-title>Productos</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'dealeroffers'}">
            <v-list-item-title>Ofertas</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item exact :to="{name: 'dealercategories'}">
            <v-list-item-title>Categorias</v-list-item-title>
            <v-list-item-icon>
              <v-icon>fas fa-circle-notch</v-icon>
            </v-list-item-icon>
          </v-list-item>
        </v-list-group>
      </v-list>
      <v-spacer></v-spacer>
      <v-list-item @click="changeTheme">
        <v-list-item-action>
          <v-icon>mdi-brightness-6</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>{{themeMessage}}</v-list-item-title>
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
          <!-- <v-flex class="shrink"> -->
          <router-view />
          <!-- </v-flex> -->
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
    darkStile: true,
    user: null,
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
    },
    themeMessage() {
      return this.darkStile === true ? "Encender luces" : "Apagar luces";
    }
  },
  watch: {
    darkStile(val) {
      this.$vuetify.theme.dark = val;
      this.$store.commit("SET_DARK_STILE", val);
    }
  },
  created() {
    this.darkStile = this.$store.getters.darkStile;
    this.$vuetify.theme.dark = this.darkStile;
    //localStorage.getItem("token_expires_in")
    this.token_expires_in = new Date(this.$store.getters.getTokenExpireIn);
    this.countdownToken();
    this.idleLifeTime = process.env.MIX_VUE_IDLE_LIFETIME_MIN * 60;
    this.user = this.$store.getters.getUser;
  },
  mounted: function() {},
  methods: {
    changeTheme() {
      this.darkStile = !this.darkStile;
    },
    logout() {
      localStorage.removeItem("vuex");
      axios.post("/api/dealer/logout").then(({ data }) => {
        if (data.message) {
          this.$router.push({ name: "authenticatedealer" });
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
          this.$router.push({ name: "authenticatedealer" });
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