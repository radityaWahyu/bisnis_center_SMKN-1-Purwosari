export const actions = {
  getReview({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`review?id=${payload}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error.response);
        });
    });
  },
  getLatest({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get(`review/latest?${payload}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error.response);
        });
    });
  },
  replyReview({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`review/reply/${payload.id}`, payload.value)
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
  deleteReview({ store }, payload) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$post(`review/delete`, payload)
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
