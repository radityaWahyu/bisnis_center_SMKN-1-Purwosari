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
    width="400px"
  >
    <template slot="title">
      <a-icon
        type="retweet"
        :style="{ fontSize: '20px', marginRight: '5px' }"
      ></a-icon>
      <span :style="{ fontSize: '20px', fontWeight: '600' }">Balas Ulasan</span>
    </template>
    <a-form
      :form="form"
      layout="vertical"
      @submit="onSaved"
      :style="{ padding: '0px' }"
    >
      <a-form-item
        :style="{ marginBottom: '0px', marginTop: '0px' }"
        label="Pesan"
        :validate-status="
          localError.pesan ? 'error' : serverError.pesan ? 'error' : ''
        "
        :help="
          serverError.pesan
            ? serverError.pesan[0]
            : localError.pesan
            ? localError.pesan.message
            : ''
        "
        has-feedback
      >
        <a-textarea
          v-decorator="[
            'pesan',
            {
              rules: [
                {
                  required: true,
                  message: 'Pesan harus diisi!'
                }
              ]
            }
          ]"
          placeholder="Masukkan pesan..."
          :disabled="submitButton.loading"
          :rows="4"
          allowClear
        />
      </a-form-item>
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
export default {
  data() {
    return {
      visible: false,
      idReview: "",
      idItem: "",
      serverError: [],
      localError: [],
      submitButton: {
        loading: false,
        text: "Kirim"
      }
    };
  },
  created() {
    this.form = this.$form.createForm(this);
  },
  methods: {
    onCreate(idReview, idItem) {
      this.idReview = idReview;
      this.idItem = idItem;
      this.visible = true;
    },
    onSaved(e) {
      e.preventDefault();
      this.form.validateFields(async (err, value) => {
        if (!err) {
          this.submitButton.text = " Mengirim...";
          this.submitButton.loading = true;

          try {
            const formData = {
              pesan: value.pesan,
              item: this.idItem
            };
            //  reply review
            await this.$store.dispatch("review/replyReview", {
              id: this.idReview,
              value: formData
            });

            //  close modal dialog
            this.onClose();
            //  reload list review
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
    }
  }
};
</script>
