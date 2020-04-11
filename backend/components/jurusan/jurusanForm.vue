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
        type="deployment-unit"
        :style="{ fontSize: '20px', marginRight: '5px' }"
      ></a-icon>
      <span :style="{ fontSize: '20px', fontWeight: '600' }">Jurusan</span>
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
        <a-input
          size="large"
          v-decorator="[
            'jurusan',
            {
              rules: [
                {
                  required: true,
                  message: 'Data jurusan harus diisi!'
                }
              ]
            }
          ]"
          placeholder="Masukkan nama..."
          :disabled="submitButton.loading"
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
import { mapActions, mapMutations } from "vuex";

export default {
  data() {
    return {
      visible: false,
      serverError: [],
      localError: [],
      edit: false,
      id: "",
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
    ...mapMutations("spinner", ["set_spinner"]),
    ...mapActions("departement", [
      "createDepartement",
      "showDepartement",
      "updateDepartement"
    ]),
    onCreate() {
      this.visible = true;
      this.edit = false;
    },
    onSaved(e) {
      e.preventDefault();
      this.form.validateFields(async (err, value) => {
        if (!err) {
          this.submitButton.text = " Proses...";
          this.submitButton.loading = true;

          try {
            if (this.edit === false) {
              //  create new departement
              await this.createDepartement(value);
            } else {
              //  update custom departement
              await this.updateDepartement({
                id: this.id,
                value
              });
            }
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
    async onEdit(id) {
      this.set_spinner({ show: true, text: "Ambil data..." });
      try {
        const { data } = await this.showDepartement(id);
        setTimeout(() => {
          this.form.setFieldsValue({
            jurusan: data.departement
          });
        }, 0);
        this.id = data.id;
        this.edit = true;
        this.set_spinner({ show: false, text: "" });
        this.visible = true;
      } catch (error) {
        alert(error);
      }
    }
  }
};
</script>
