<template>
  <v-app id="inspire">
    <v-app-bar app clipped-left>
      <v-toolbar-title>
        <transition :name="transitionName">
          <router-link :to="{ name: 'indexstore'}">Argus</router-link>
        </transition>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-chip class="ma-2" color="orange darken-3" outlined>
        <v-icon left>fas fa-key</v-icon>Token expira en:
      </v-chip>
    </v-app-bar>
    <v-main app>
      <v-container class="fill-height" fluid>
        <v-layout class="justify-center">
          <v-flex class="shrink">
            <router-view />
          </v-flex>
        </v-layout>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  data: () => ({
    transitionName: 'slide-left'
  }),
  computed: {},
  watch: {
    $route(to, from) {
      const toDepth = to.path.split("/").length;
      const fromDepth = from.path.split("/").length;
      this.transitionName = toDepth < fromDepth ? "slide-right" : "slide-left";
    }
  },
  created() {},
  methods: {}
};
</script>