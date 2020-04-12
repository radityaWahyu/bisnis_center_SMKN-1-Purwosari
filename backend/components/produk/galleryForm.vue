<template>
  <a-modal
    v-model="visible"
    :closable="false"
    :footer="null"
    :bodyStyle="{
      padding: '10px 10px 0px 10px',
      backgroundColor: '#F2F4F7',
      borderRadius: '0px 0px 3px 3px'
    }"
    :keyboard="false"
    :maskClosable="false"
    :afterClose="onClose"
    width="500px"
  >
    <template slot="title">
      <a-icon
        type="file-image"
        :style="{ fontSize: '20px', marginRight: '5px' }"
      ></a-icon>
      <span :style="{ fontSize: '20px', fontWeight: '600' }">Gambar</span>
    </template>
    <a-form
      :form="form"
      layout="vertical"
      @submit="onSaved"
      :style="{ padding: '0px' }"
    >
      <a-form-item
        :style="{ marginBottom: '0px', marginTop: '0px' }"
        label="Nama Jurusan"
        :validate-status="
          localError.caption ? 'error' : serverError.caption ? 'error' : ''
        "
        :help="
          serverError.caption
            ? serverError.caption[0]
            : localError.caption
            ? localError.caption.message
            : ''
        "
        has-feedback
      >
        <a-input
          size="large"
          v-decorator="[
            'caption',
            {
              rules: [
                {
                  required: true,
                  message: 'Caption harus diisi!'
                }
              ]
            }
          ]"
          placeholder="Masukkan caption..."
          :disabled="submitButton.loading"
          allowClear
        />
      </a-form-item>
      <img
        :src="image"
        alt=""
        width="480px"
        height="350px"
        v-if="image.length > 0"
        class="produk-image"
      />
      <a-upload
        name="file"
        accept="image/*"
        :beforeUpload="beforeUpload"
        :showUploadList="false"
      >
        <a-button
          type="default"
          size="large"
          :style="{ width: '480px', marginTop: '10px', marginBottom: '10px' }"
          block
        >
          <a-icon type="upload" /> Pilih Gambar
        </a-button>
      </a-upload>
      <a-form-item :style="{ marginTop: '10px', textAlign: 'right' }">
        <a-button
          size="large"
          type="link"
          @click="onClose"
          :disabled="submitButton.loading"
        >
          <a-icon type="close-circle" />Batalkan
        </a-button>
        <a-button
          type="primary"
          html-type="submit"
          size="large"
          :loading="submitButton.loading"
          :style="{ width: '10em' }"
        >
          <a-icon type="check-circle" v-if="!submitButton.loading" />
          {{ submitButton.text }}
        </a-button>
      </a-form-item>
    </a-form>
  </a-modal>
</template>
<script>
import { mapActions } from "vuex";

export default {
  props: {
    id: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      visible: false,
      imageData: [],
      image: "",
      serverError: [],
      localError: [],
      submitButton: {
        loading: false,
        text: "Simpan"
      }
    };
  },
  created() {
    this.form = this.$form.createForm(this);
  },
  methods: {
    ...mapActions("gallery", ["createGallery"]),
    onCreate() {
      this.visible = true;
    },
    onSaved(e) {
      e.preventDefault();
      this.form.validateFields(async (err, value) => {
        if (!err) {
          this.submitButton.text = " Proses...";
          this.submitButton.loading = true;

          if (this.image.length === 0) {
            this.$notification.error({
              message: "Kesalahan",
              description: "Gambar produk atau jasa belum di pilih"
            });
          } else {
            try {
              const fd = new FormData();
              fd.append("item_id", this.id);
              fd.append("caption", value.caption);
              fd.append("image", this.imageData);

              //  create new departement
              await this.createGallery(fd);
              //  close modal dialog
              this.onClose();
              //  redirect to page jurusan
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
            }
          }
          //  reset form on modal dialog
          this.submitButton.text = "Simpan";
          this.submitButton.loading = false;
        } else {
          //  set local error from async-validator
          this.localError = err;
        }
      });
    },
    onClose() {
      this.visible = false;
      this.localError = [];
      this.form.resetFields();
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
