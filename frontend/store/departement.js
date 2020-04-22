export const state = () => ({
  departement: [],
});

export const getters = {
  getDepartement: (state) => state.departement,
};

export const mutations = {
  setDepartement(state, value) {
    state.departement = value;
  },
};
export const actions = {
  listDepartement({ commit }) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`departement/list`)
        .then((response) => {
          commit("setDepartement", response.data);
          resolve(response);
        })
        .catch((error) => {
          reject(error.response);
        });
    });
  },
  showDepartement({ state }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`departement/${payload}`)
        .then((response) => {
          console.log(response);
          if (response.status) {
            resolve(response);
          } else {
            reject(response);
          }
        })
        .catch((error) => {
          reject(error.response);
        });
    });
  },
};
