export const state = () => ({
  spinner: {
    show: false,
    text: "Loading..."
  }
});

export const getters = {
  get_spinner: state => state.spinner
};

export const mutations = {
  set_spinner(state, value) {
    state.spinner = value;
  }
};
