export const actions = {
  getProduct({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`item?${payload}`)
        .then((response) => {
          resolve(response);
        })
        .catch((error) => {
          reject(error.response);
        });
    });
  },
  showProduct({ state }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`item/${payload}`)
        .then((response) => {
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
