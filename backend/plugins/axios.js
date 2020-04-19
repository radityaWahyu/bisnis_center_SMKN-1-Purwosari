export default function({ $axios, store, redirect }) {
  // if (store.state.auth.token) {
  // $axios.setToken(store.state.auth.token, "Bearer");
  // }
  $axios.setHeader("Content-Type", "multipart/form-data");

  $axios.onResponseError(error => {
    if (!error.response) {
      // console.log("Tidak bisa terhubung dengan server");
      return redirect("/error/notConnected");
    } else if (error.response.statusText) {
      return redirect("/");
    } else {
      console.log(error.response);
    }
  });
  $axios.onRequest(config => {
    if (store.state.auth.token) {
      config.headers.common.Authorization = `Bearer ${store.state.auth.token}`;
    }
  });
}
