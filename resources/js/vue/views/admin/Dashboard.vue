<template>
  <v-content class="neuro__color">
    <v-container fill-height fluid>
      <v-row align="center" justify="center">
        <v-col cols="12">
          <div class="d-flex align-content-center justify-space-between flex-wrap  neuro__color">
            <div v-for="(item, index) in items" :key="index">
              <div class="dashboard__item mr-8 mb-16">
                <div class="player__controls">
                  <h5 class="player__title">{{item.name}}</h5>
                </div>
                <h2 class="player__artist black--text">{{item.quantity}}</h2>
                <h3 class="player__song black--text">Registrados</h3>
              </div>
            </div>
          </div>
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
    drawer: null,
    items: [],
  }),
  created() {
    this.initialize()
  },
  methods:{
    initialize(){
      axios.get("/api/admins/dashboard").then(({ data }) => {
        this.items = data
      });
    }
  }
};
</script>
<style>
:root {
  --background: #e0e5ec;
  --gray: #797d7f;
}
.neuro__color {
  background-color: #e0e5ec !important;
}

.dashboard__item {
  /* Basic styling and alignment */
  margin-left: auto;
  margin-right: auto;
  margin-top: 10px;

  width: 15rem;
  height: 10rem;
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
  box-shadow: -8px -8px 20px #fff9, -5px -5px 10px 0px #ffff, 8px 8px 20px #0001,
    5px 5px 6px 0px #0001;
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
.player__title {
  font-weight: 600;
  font-size: 0.8em;
  color: #a1a1a1;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin: 0;
}
</style>