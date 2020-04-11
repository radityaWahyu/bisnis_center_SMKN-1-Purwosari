export const actions = {
  count({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`count`, { path: payload })
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
