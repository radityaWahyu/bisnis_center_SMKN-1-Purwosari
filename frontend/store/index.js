export const state = () => ({
  burger: false,
  activeNav: "",
});

export const getters = {
  getBurger: (state) => state.burger,
  getActiveNav: (state) => state.activeNav,
};

export const mutations = {
  setBurger(state, value) {
    state.burger = value;
  },
  setActiveNav(state, value) {
    state.activeNav = value;
  },
};
export const actions = {
  async nuxtServerInit({ dispatch }) {
    await dispatch("departement/listDepartement");
  },
  menuActive({ commit }, payload) {
    return new Promise((resolve, reject) => {
      const path = payload.split("/");
      if (path[1].length === 0) {
        commit("setActiveNav", "beranda");
      } else if (path[1] === "detail") {
        commit("setActiveNav", "produk");
      } else {
        commit("setActiveNav", path[1]);
      }
      resolve(true);
    });
  },
};
