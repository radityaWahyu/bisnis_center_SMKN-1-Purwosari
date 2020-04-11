import Vue from "vue";

const Helper = {
  install(Vue) {
    Vue.prototype.appName = process.env.VUE_APP_NAME;
    Vue.prototype.getImage = function(image) {
      if (image != null && image.length > 0) {
        return process.env.IMAGE_URL + "/" + image;
      }
      return "/_nuxt/assets/image/image_unavaible.jpg";
    };
    Vue.prototype.getAvatar = function(image) {
      if (image != null && image.length > 0) {
        return process.env.IMAGE_URL + "/thumbnail/user/" + image;
      }
      return "/_nuxt/assets/image/login_back.jpg";
    };
    // Vue.prototype.getThumbnail = function(image) {
    //     if(image!=null && image.length>0){
    //         return process.env.VUE_APP_BACKEND_URL + "/uploads"+ image;
    //     }
    //     return process.env.VUE_APP_BACKEND_URL + "/uploads/image_unavaible.png";
    // }
  }
};
Vue.use(Helper);
