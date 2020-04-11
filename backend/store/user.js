export const actions = {
  getUser({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`user?${payload}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error.response);
        });
    });
  },
  getChart({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`statistic/chart?${payload}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error.response);
        });
    });
  },
  createUser({ store }, value) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`user`, value, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
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
  },
  deleteUser(payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`user/delete`, payload)
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
  },
  showUser({ state }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`user/${payload}`)
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
  },
  updateUser({ state }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`user/${payload.id}?_method=PATCH`, payload.value, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          if (response.status) {
            resolve(response);
          } else {
            reject(response);
          }
        });
    });
  }
};
