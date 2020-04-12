export const actions = {
  getGallery({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`gallery?${payload}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error.response);
        });
    });
  },
  createGallery({ store }, value) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`gallery`, value, {
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
  deleteGallery(state, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`gallery/delete`, payload)
        .then(response => {
          // resolve(response);
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
  showGallery({ state }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`gallery/${payload}`)
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
