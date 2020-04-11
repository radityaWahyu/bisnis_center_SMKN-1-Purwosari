<template>
  <a-form :form="form" layout="vertical" :style="{ padding: '0px' }">
    <a-row justify="space-between" type="flex">
      <a-col :span="6">
        <img
          :src="image"
          alt=""
          width="305px"
          height="200px"
          v-if="image.length > 0"
        />
        <img src="~assets/image/image_upload.jpg" alt="" width="305px" v-else />
        <a-upload
          name="file"
          accept="image/*"
          :beforeUpload="beforeUpload"
          :showUploadList="false"
        >
          <a-button
            type="primary"
            size="large"
            :style="{ width: '305px', marginTop: '10px', marginBottom: '10px' }"
            block
          >
            <a-icon type="upload" /> Pilih Gambar
          </a-button>
        </a-upload>
        <a-form-item
          v-if="user.level === 'admin'"
          :style="{ marginBottom: '5px', marginTop: '5px' }"
          label="Jurusan"
          :validate-status="
            localError.jurusan ? 'error' : serverError.jurusan ? 'error' : ''
          "
          :help="
            serverError.jurusan
              ? serverError.jurusan[0]
              : localError.jurusan
              ? localError.jurusan.message
              : ''
          "
          has-feedback
        >
          <a-select
            size="large"
            v-decorator="[
              'jurusan',
              {
                rules: [
                  {
                    required: true,
                    message: 'Pilih Jurusan terlebih dahulu'
                  }
                ]
              }
            ]"
            placeholder="Pilih Jurusan"
          >
            <a-select-option v-for="row in jurusan" :key="row.id">
              {{ row.departement }}
            </a-select-option>
          </a-select>
        </a-form-item>
      </a-col>
      <a-col :span="17">
        <a-form-item
          :style="{ marginBottom: '10px' }"
          has-feedback
          :validate-status="
            localError.judul ? 'error' : serverError.judul ? 'error' : ''
          "
          :help="
            serverError.judul
              ? serverError.judul[0]
              : localError.judul
              ? localError.judul.message
              : ''
          "
        >
          <a-input
            size="large"
            v-decorator="[
              'judul',
              {
                rules: [
                  {
                    required: true,
                    message: 'Data judul harus diisi!'
                  }
                ]
              }
            ]"
            placeholder="Masukkan judul..."
            allowClear
          >
            <a-icon slot="prefix" type="highlight" />
          </a-input>
        </a-form-item>
        <ckeditor
          :editor="editor"
          v-model="editorData"
          :config="editorConfig"
        ></ckeditor>
      </a-col>
    </a-row>
  </a-form>
</template>
<script>
import { mapActions, mapMutations, mapGetters } from "vuex";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { UploadAdapter } from "../../plugins/uploadAdapter.js";

export default {
  props: {
    id: {
      type: String,
      required: false
    }
  },
  data() {
    return {
      loader: [],
      uploadImage: "",
      editor: ClassicEditor,
      editorData: "",
      image: "",
      imageFile: [],
      jurusan: [],
      serverError: [],
      localError: [],
      listValidate: "",
      editorConfig: {
        placeholder: "Masukkan deskripsi dari produk atau jasa...",
        extraPlugins: [this.uploadImageEditor],
        toolbar: [
          "heading",
          "|",
          "bold",
          "italic",
          "bulletedList",
          "numberedList",
          "|",
          "imageUpload",
          "indent",
          "outdent",
          "blockQuote",
          "undo",
          "redo"
        ]
      }
    };
  },
  created() {
    // console.log(ClassicEditor.defaultConfig.toolbar);
    this.form = this.$form.createForm(this);
  },
  computed: {
    ...mapGetters({
      user: "auth/get_user"
    })
  },
  watch: {
    id: {
      deep: true,
      immediate: true,
      handler(value) {
        this.getList();

        if (value !== undefined) {
          this.getPost(value);
        }
      }
    }
  },
  methods: {
    ...mapMutations("spinner", ["set_spinner"]),
    ...mapActions("departement", ["getListDepartement"]),
    ...mapActions("news", ["createPost", "showPost"]),
    async getPost(id) {
      this.set_spinner({ show: true, text: "Ambil Data..." });
      try {
        const { data } = await this.showPost(id);
        setTimeout(() => {
          if (this.user.level === "admin") {
            this.form.setFieldsValue({
              jurusan: data.departement_id,
              judul: data.title
            });
          } else {
            this.form.setFieldsValue({
              judul: data.title
            });
          }
        }, 0);
        this.editorData = data.content;
        if (data.image !== null) {
          this.image = process.env.IMAGE_URL + "/thumbnail/post/" + data.image;
        } else {
          this.image = "~assets/image/image_unavaible.png";
        }

        setTimeout(() => {
          this.set_spinner({ show: false, text: "" });
        }, 500);
      } catch (error) {
        alert(error);
      }
    },
    savePost(type) {
      this.form.validateFields(async (err, value) => {
        if (!err) {
          if (this.image.length === 0) {
            this.$notification.error({
              message: "Kesalahan",
              description: "Gambar berita belum di pilih"
            });
          } else {
            this.set_spinner({ show: true, text: "Menyimpan..." });
            try {
              const fd = new FormData();
              fd.append("judul", value.judul);

              if (this.user.level === "admin") {
                fd.append("jurusan", value.jurusan);
              } else {
                fd.append("jurusan", this.user.departement_id);
              }
              fd.append("content", this.editorData);
              if (type === "publish") {
                fd.append("publish", 1);
              } else {
                fd.append("publish", 0);
              }
              fd.append("image", this.imageData);

              await this.createPost(fd);
              this.set_spinner({ show: false, text: "" });
              this.$emit("saved", true);
            } catch (error) {
              const errMsg = "";
              //  check when error 422 from server
              if (error.status === 422) {
                this.serverError = error.data.errors;
              } else if (error !== "undefined") {
                this.$notification.error({
                  message: "Kesalahan",
                  description: errMsg
                });
              }
              this.set_spinner({ show: false, text: "" });
            }
          }
        } else {
          //  set local error from async-validator
          this.localError = err;
        }
      });
    },
    updatePost(type) {
      this.form.validateFields(async (err, value) => {
        if (!err) {
          this.set_spinner({ show: true, text: "Menyimpan..." });
          try {
            const fdUpdate = new FormData();
            fdUpdate.append("judul", value.judul);
            if (this.user.level === "admin") {
              fdUpdate.append("jurusan", value.jurusan);
            } else {
              fdUpdate.append("jurusan", this.user.departement_id);
            }
            fdUpdate.append("content", this.editorData);
            if (type === "publish") {
              fdUpdate.append("publish", 1);
            } else {
              fdUpdate.append("publish", 0);
            }
            fdUpdate.append("image", this.imageData);

            // call function to update data product
            await this.$store.dispatch("news/updatePost", {
              id: this.id,
              value: fdUpdate
            });
            this.set_spinner({ show: false, text: "" });
            this.$emit("saved", true);
          } catch (error) {
            const errMsg = "";
            //  check when error 422 from server
            if (error.status === 422) {
              this.serverError = error.data.errors;
            } else if (error !== "undefined") {
              this.$notification.error({
                message: "Kesalahan",
                description: errMsg
              });
            }
            this.set_spinner({ show: false, text: "" });
          }
        } else {
          //  set local error from async-validator
          this.localError = err;
        }
      });
    },
    async getList() {
      try {
        this.listValidate = "validating";
        // get list from departement
        const departementList = await this.getListDepartement();

        this.jurusan = departementList.data;

        this.listValidate = "";
      } catch (error) {
        console.log(error);
      }
    },
    beforeUpload(file) {
      if (file.size > 2000000) {
        this.$notification.error({
          message: "Kesalahan",
          description:
            "Ukuran gambar melebihi 2MB, silahkan di perkecil ukuran gambar"
        });
      } else {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = event => {
          this.image = event.target.result;
        };
        this.imageData = file;
      }

      return false;
    },
    uploadImageEditor(editor) {
      editor.plugins.get("FileRepository").createUploadAdapter = loader => {
        return new UploadAdapter(loader);
      };
    }
  }
};
</script>
