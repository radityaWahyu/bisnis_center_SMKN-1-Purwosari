export const actions = {
  getProduct({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`item?${payload}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error.response);
        });
    });
  },
  createProduct({ store }, value) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`item`, value, {
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
  deleteProduct({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`item/delete`, payload)
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
  showProduct({ state }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`item/${payload}`)
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
  updateProduct({ state }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`item/${payload.id}?_method=PATCH`, payload.value, {
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
  },
  setBest({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`item/is_best/${payload.id}`, { is_best: payload.value })
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
