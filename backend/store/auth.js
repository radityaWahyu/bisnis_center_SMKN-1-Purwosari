import cookies from "js-cookie";

export const state = () => ({
  token: null,
  user: []
});

export const getters = {
  get_user: state => state.user
};

export const mutations = {
  set_user(state, value) {
    state.user = value;
  },
  set_token(state, token) {
    state.token = token;
  },
  remove_token(state) {
    state.token = null;
  },
  remove_user(state) {
    state.user = [];
  }
};

export const actions = {
  setToken({ commit }, { token, expired }) {
    //  set axios token for transaction system
    this.$axios.setToken(token, "Bearer");

    //  set expired time for user token
    //  const expiryTime = new Date(new Date().getTime + expired * 1000);

    //  set cookies with new variable x-access-token with user token
    cookies.set("x-access-token", token, {
      expires: 1,
      path: "/"
    });

    commit("set_token", token);
  },
  refreshToken({ dispatch, commit, redirect }) {
    //  get new token when user token expired
    this.$axios
      .$get("refresh-token")
      .then(({ token, expired }) => {
        dispatch("setToken", {
          token,
          expired
        });
      })
      .catch(error => {
        console.log(error.response);
      });
  },
  getUser({ commit }) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get("getUser")
        .then(response => {
          //  console.log(response)
          commit("set_user", response.data);
          resolve(response.data);
        })
        .catch(error => {
          reject(error.response);
          console.log(error.response);
        });
    });
  },
  login({ dispatch }, value) {
    return new Promise((resolve, reject) => {
      //  send data to routes API login to check username and password
      this.$axios
        .$post("login", value)
        .then(response => {
          console.log(response);
          if (response.status === false) {
            reject(response);
          } else {
            dispatch("setToken", {
              token: response.token,
              expired: response.expired
            });
            resolve(response.message);
          }
        })
        .catch(error => {
          if (!error.response) {
            const status = "undefined";
            reject(status);
          } else if (error.response.status === 422) {
            reject(error.response);
          }
        });
    });
  },
  logout({ commit }) {
    return new Promise((resolve, reject) => {
      this.$axios
        .$get("logout")
        .then(response => {
          //  remove cookies variable x-access-token
          cookies.remove("x-access-token");
          //  remove from vuex state
          commit("remove_token");
          commit("remove_user");

          resolve(response);
        })
        .catch(error => {
          reject(error.response);
        });
    });
  }
};
