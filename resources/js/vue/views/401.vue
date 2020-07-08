<template>
  <v-app>
    <v-content>
      <v-container fill-height fluid>
        <v-row align="center" justify="center">
          <v-col cols="12" sm="8" md="8">
            <v-card class="elevation-12">
              <v-row>
                <v-col cols="12">
                  <v-card-text class="mt-10">
                    <h1 class="text-center display-2 orange--text text--accent-4">
                      <strong>Error 401 ...</strong>
                    </h1>
                    <v-img src="/images/401_2.svg" aspect-ratio="2" contain></v-img>
                    <h3 class="text-center orange--text mb-10">Acceso no autorizado!!!</h3>
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
  created() {
    this.$vuetify.theme.dark = this.$store.getters.darkStile;
  },
};
</script>