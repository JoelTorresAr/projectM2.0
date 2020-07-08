<template>
  <v-content class="neuro__color">
    <v-container fill-height fluid>
      <v-row align="center" justify="center">
        <v-col cols="12">
          <v-card>
            <v-row>
              <v-col cols="12" md="8" class="neuro__color">
                <v-card-text class="mt-10">
                  <div class="player">
                    <div class="player__controls">
                      <div class="player__btn player__btn--small">
                        <i class="fas fa-arrow-left"></i>
                      </div>
                      <h5 class="player__title">Playing now</h5>
                      <div class="player__btn player__btn--small">
                        <i class="fas fa-bars"></i>
                      </div>
                    </div>
                    <h2 class="player__artist">Disclosure</h2>
                    <h3 class="player__song">Latch</h3>
                  </div>
                </v-card-text>
              </v-col>
              <v-col cols="12" md="4" class="orange accent-4">
                <v-card-text class="black--text mt-12">
                  <h1 class="text-center display-1">Bienvenido!</h1>
                  <h5 class="text-center">Ingresa tus datos para iniciar sesión</h5>
                </v-card-text>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-content>
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
<style>
:root {
  --background: #e0e5ec;
  --gray: #797d7f;
}
.neuro__color {
  background-color: #e0e5ec;
}

.player {
  /* Basic styling and alignment */
  margin-left: auto;
  margin-right: auto;
  margin-top: 10px;

  width: 300px;
  height: 550px;
  background-color: var(--background);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  border-radius: 12px;
  /* Basic styling and alignment */ /* For Neumorphism Effect */
  box-shadow: 9px 9px 16px rgba(163, 177, 198, 0.6),
    -9px -9px 16px rgba(255, 255, 255, 0.5);
  /* For Neumorphism Effect */
}
.player__controls {
  display: flex;
  width: 95%;
  justify-content: space-evenly;
  align-items: center;
  margin-bottom: 25px;
}
.player__btn {
  cursor: pointer;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  background: linear-gradient(145deg, #cdcdcd, #adadad);
  box-shadow: -8px -8px 20px #fff9, -5px -5px 10px 0px #ffff,
              8px 8px 20px #0001, 5px 5px 6px 0px #0001;
  color: var(--gray);
}
.player__btn:active {
  box-shadow: inset -8px -8px 20px 0px #fff9, inset -5px -5px 8px 20px #0001,
    inset 5px 5px 6px 0px #0001;
}
.player__btn--small {
  min-width: 50px;
  min-height: 50px;
}
.player__title{
  font-weight: 600;
  font-size: 0.8em;
  color: #a1a1a1;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin: 0;
}
</style>