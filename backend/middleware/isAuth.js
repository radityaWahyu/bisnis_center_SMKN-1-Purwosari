async function isAuth({ store, redirect, route }) {
  await store.dispatch("navigation/menuActive", route.path);

  if (!store.state.auth.token) {
    return redirect("/");
  } else if (store.state.auth.user.length === 0) {
    store.dispatch("auth/getUser");
  }
}

export default isAuth;
