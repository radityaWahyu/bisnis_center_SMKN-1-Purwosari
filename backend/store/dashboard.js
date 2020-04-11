export const actions = {
  getCount({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`statistic/count?type=${payload}`)
        .then(response => {
          if (response.status) {
            resolve(response);
          } else {
            reject(response);
          }
        })
        .catch(error => {
          reject(error.response);
        });
    });
  }
};
