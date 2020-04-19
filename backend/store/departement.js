export const actions = {
  getDepartement({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`departement?${payload}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error.response);
        });
    });
  },
  createDepartement({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`departement`, payload)
        .then(response => {
          resolve(response);
          // if (response.status) {
          //   resolve(response);
          // } else {
          //   reject(response);
          // }
        })
        .catch(error => {
          reject(error.response);
        });
    });
  },
  deleteDepartement({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post("departement/delete", payload)
        .then(response => {
          console.log(response);
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
  showDepartement({ state }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`departement/${payload}`)
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
  updateDepartement({ state }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`departement/${payload.id}?_method=PATCH`, payload.value)
        .then(response => {
          if (response.status) {
            resolve(response);
          } else {
            reject(response);
          }
        });
    });
  },
  getListDepartement() {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`departement/list`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error.response);
        });
    });
  }
};
