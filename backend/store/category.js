export const actions = {
  getCategory({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`category?${payload}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error.response);
        });
    });
  },
  createCategory({ store }, value) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`category`, value)
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
  deleteCategory(payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`category/delete`, payload)
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
  showCategory({ state }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`category/${payload}`)
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
  updateCategory({ state }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`category/${payload.id}?_method=PATCH`, payload.value)
        .then(response => {
          if (response.status) {
            resolve(response);
          } else {
            reject(response);
          }
        });
    });
  },
  getListCategory() {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`category/list`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error.response);
        });
    });
  }
};
