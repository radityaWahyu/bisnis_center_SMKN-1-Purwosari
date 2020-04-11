async function count({ store, route }) {
  try {
    await store.dispatch("countPage/count", route.path);
    await store.dispatch("menuActive", route.path);
    // console.log(response);
  } catch (error) {
    console.log(error);
  }
}

export default count;
