import axios from "axios";
import cookies from "js-cookie";

export class UploadAdapter {
  constructor(loader) {
    this.loader = loader;
  }

  upload() {
    return this.loader.file.then(uploadedFile => {
      const formData = new FormData();
      formData.append("image", uploadedFile);
      return new Promise((resolve, reject) => {
        const formData = new FormData();
        formData.append("id", this.loader.id);
        formData.append("image", uploadedFile);
        axios
          .post(`${process.env.API_URL}/post/upload`, formData, {
            headers: {
              "Content-type": "multipart/form-data",
              Authorization: `Bearer ${cookies.get("x-access-token")}`
            }
          })
          .then(response => {
            if (response.data.status) {
              resolve({ default: response.data.url });
            } else {
              reject(response.data);
            }
          })
          .catch(error => {
            reject(error.response);
          });
      });
    });
    //
  }
  abort() {}
}
