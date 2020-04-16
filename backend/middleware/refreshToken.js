import cookies from "js-cookie";

export default function({ store }) {
  const token = cookies.get("x-access-token");

  if (token !== undefined) {
    if (token.length === 0) {
      store.dispatch("auth/refreshToken");
    } else {
      store.commit("auth/set_token", token);
    }
  }
}
