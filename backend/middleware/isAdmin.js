async function isOperator({ store, error }) {
  try {
    const response = await store.dispatch("auth/getUser");

    if (response.level === "operator") {
      return error({
        statusCode: 401,
        message: "Maaf, Anda tidak diijinkan mengakses halaman ini"
      });
    }
  } catch (error) {
    return error({
      statusCode: 500,
      message: error
    });
  }
}

export default isOperator;
