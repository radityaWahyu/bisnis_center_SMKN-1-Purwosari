export const actions = {
  getActivity({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`activity?${payload}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error.response);
        });
    });
  },
  getActivityDetail({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`activity/${payload}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error.response);
        });
    });
  }
};
