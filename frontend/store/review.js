export const actions = {
  getReview({ commit }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`review?${payload}`)
        .then((response) => {
          resolve(response);
        })
        .catch((error) => {
          reject(error.response);
        });
    });
  },
  sendReview({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`review`, payload)
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
