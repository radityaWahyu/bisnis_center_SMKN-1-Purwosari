<template>
  <a-form :form="form" layout="vertical" :style="{ padding: '0px' }">
    <a-row justify="space-between" type="flex">
      <a-col :span="6">
        <img
          :src="image"
          alt=""
          width="305px"
          height="350px"
          v-if="image.length > 0"
          class="produk-image"
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
          :style="{ marginBottom: '5px', marginTop: '5px' }"
          label="Kategori"
          :validate-status="
            localError.kategori ? 'error' : serverError.kategori ? 'error' : ''
          "
          :help="
            serverError.kategori
              ? serverError.kategori[0]
              : localError.kategori
              ? localError.kategori.message
              : ''
          "
          has-feedback
        >
          <a-select
            size="large"
            v-decorator="[
              'kategori',
              {
                rules: [
                  {
                    required: true,
                    message: 'Pilih Kategori terlebih dahulu'
                  }
                ]
              }
            ]"
            placeholder="Pilih kategori"
          >
            <a-select-option v-for="row in kategori" :key="row.id">
              {{ row.category }}
            </a-select-option>
          </a-select>
        </a-form-item>
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

export default {
  props: {
    id: {
      type: String,
      required: false
    }
  },
  data() {
    return {
      editor: ClassicEditor,
      editorData: "",
      image: "",
      imageData: [],
      kategori: [],
      jurusan: [],
      serverError: [],
      localError: [],
      listValidate: "",
      editorConfig: {
        placeholder: "Masukkan deskripsi dari produk atau jasa...",
        toolbar: [
          "heading",
          "|",
          "bold",
          "italic",
          "bulletedList",
          "numberedList",
          "|",
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
          this.getProduct(value);
        }
      }
    }
  },
  methods: {
    ...mapMutations("spinner", ["set_spinner"]),
    ...mapActions("category", ["getListCategory"]),
    ...mapActions("departement", ["getListDepartement"]),
    ...mapActions("product", ["createProduct", "showProduct"]),
    async getProduct(id) {
      this.set_spinner({ show: true, text: "Ambil Data..." });
      try {
        const { data } = await this.showProduct(id);
        setTimeout(() => {
          if (this.user.level === "admin") {
            this.form.setFieldsValue({
              kategori: data.category_id,
              jurusan: data.departement_id,
              judul: data.title
            });
          } else {
            this.form.setFieldsValue({
              kategori: data.category_id,
              judul: data.title
            });
          }
        }, 0);
        this.editorData = data.description;
        if (data.image !== null) {
          this.image = process.env.IMAGE_URL + "/thumbnail/item/" + data.image;
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
    saveProduct() {
      this.form.validateFields(async (err, value) => {
        if (!err) {
          if (this.image.length === 0) {
            this.$notification.error({
              message: "Kesalahan",
              description: "Gambar produk atau jasa belum di pilih"
            });
          } else {
            this.set_spinner({ show: true, text: "Menyimpan..." });
            try {
              const fd = new FormData();
              fd.append("judul", value.judul);
              fd.append("kategori", value.kategori);

              if (this.user.level === "admin") {
                fd.append("jurusan", value.jurusan);
              } else {
                fd.append("jurusan", this.user.departement_id);
              }

              fd.append("deskripsi", this.editorData);
              fd.append("image", this.imageData);

              await this.createProduct(fd);
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
    updateProduct() {
      this.form.validateFields(async (err, value) => {
        if (!err) {
          this.set_spinner({ show: true, text: "Menyimpan..." });
          try {
            const fdUpdate = new FormData();
            fdUpdate.append("judul", value.judul);
            fdUpdate.append("kategori", value.kategori);
            if (this.user.level === "admin") {
              fdUpdate.append("jurusan", value.jurusan);
            } else {
              fdUpdate.append("jurusan", this.user.departement_id);
            }
            fdUpdate.append("deskripsi", this.editorData);
            fdUpdate.append("image", this.imageData);

            // call function to update data product
            await this.$store.dispatch("product/updateProduct", {
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
        // get list from category
        const categoryList = await this.getListCategory();
        // get list from departement
        const departementList = await this.getListDepartement();

        this.kategori = categoryList.data;
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
    }
  }
};
</script>
