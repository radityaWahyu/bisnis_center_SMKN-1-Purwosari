export const actions = {
  getNews({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`post?${payload}`)
        .then((response) => {
          resolve(response);
        })
        .catch((error) => {
          reject(error.response);
        });
    });
  },
  showNews({ state }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`post/${payload}`)
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
