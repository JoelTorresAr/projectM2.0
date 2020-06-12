<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" app clipped>
      <v-list dense>
        <v-list-item exact to="/admin">
          <v-list-item-action>
            <v-icon>mdi-view-dashboard</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Dahsboard</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-group no-action prepend-icon="mdi-account-circle">
          <template v-slot:activator>
            <v-list-item-title>Users</v-list-item-title>
          </template>
          <v-list-item exact to="/admin/users">
            <v-list-item-title>Dahsboard</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-view-dashboard</v-icon>
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
    </v-navigation-drawer>

    <v-app-bar app clipped-left>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>Application</v-toolbar-title>
    </v-app-bar>

    <v-content>
      <v-container class="fill-height" fluid>
        <v-layout class="justify-center">
          <v-flex class="shrink">
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>

    <v-footer app class="teal--text text--accent-3">
      <v-container fill-height fluid class="justify-center">
        <span>&copy; 2020</span>
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
    drawer: null
  }),
  created() {
    this.$vuetify.theme.dark = true;
  }
};
</script>