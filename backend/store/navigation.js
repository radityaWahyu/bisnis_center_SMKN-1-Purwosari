export const state = () => ({
  active: "1"
});

export const getters = {
  get_active: state => state.active.split(",")
};

export const mutations = {
  set_active(state, value) {
    state.active = String(value);
  }
};

export const actions = {
  menuActive({ commit }, payload) {
    return new Promise((resolve, reject) => {
      const path = payload.split("/");
      if (path[1].length === 0) {
        commit("set_active", 1);
      } else if (path[1] === "jurusan") {
        commit("set_active", 3);
      } else if (path[1] === "produk") {
        commit("set_active", 4);
      } else if (path[1] === "berita") {
        commit("set_active", 5);
      } else if (path[1] === "user") {
        commit("set_active", 6);
      } else if (path[1] === "activity") {
        commit("set_active", 7);
      }
      resolve(true);
    });
  }
};
