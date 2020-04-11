export const actions = {
  getPost({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`post?${payload}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error.response);
        });
    });
  },
  createPost({ store }, value) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`post`, value, {
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
  deletePost(payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`post/delete`, payload)
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
  showPost({ state }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`post/${payload}`)
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
  updatePost({ state }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`post/${payload.id}?_method=PATCH`, payload.value, {
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
  setPublish({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`post/publish/${payload.id}`, { publish: payload.value })
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
