<template>
  <div>
    <a-row
      type="flex"
      justify="space-around"
      align="middle"
      :style="{ height: '100vh', backgroundColor: '#ECECEC' }"
    >
      <a-card class="login-box" :bordered="false">
        <a-row :style="{ padding: '0px' }">
          <a-col
            :xs="{ span: 24 }"
            :lg="{ span: 14 }"
            class="background"
            :style="{ padding: '10px 20px' }"
          >
            <div :style="{ marginTop: '10px', textAlign: 'left' }">
              <h2
                :style="{
                  fontSize: '1em',
                  color: '#2F495E',
                  fontWeight: '600',
                  margin: '0px',
                  lineHeight: '10px'
                }"
              >
                Pusat Bisnis
              </h2>
              <h2
                :style="{
                  fontSize: '1.5em',
                  color: '#2F495E',
                  fontWeight: 'bold',
                  margin: '0px'
                }"
              >
                SMK NEGERI 1 PURWOSARI
              </h2>
            </div>
          </a-col>
          <a-col
            :xs="{ span: 24 }"
            :lg="{ span: 10 }"
            :style="{
              padding: '10px 20px',
              backgroundColor: '#fafafa',
              height: '500px'
            }"
          >
            <div>
              <h2
                :style="{
                  fontWeight: '600',
                  fontSize: '2em',
                  marginBottom: '10px'
                }"
              >
                Sistem Pusat Bisnis
              </h2>
              <p
                :style="{
                  marginBottom: '20px',
                  lineHeight: '20px',
                  padding: '0px'
                }"
              >
                Sistem yang dipergunakan untuk memanajemen semua data, setiap
                user yang terdaftar wajib mengisikan username dan password.
                Apabila belum terdaftar silahkan menghubungi
                <strong>Administrator</strong>.
              </p>
            </div>
            <a-form :form="form" layout="vertical" @submit="handleSubmit">
              <a-form-item
                :style="{ marginBottom: '0px', marginTop: '0px' }"
                :validate-status="
                  localError.email ? 'error' : serverError.email ? 'error' : ''
                "
                :help="
                  serverError.email
                    ? serverError.email[0]
                    : localError.email
                    ? localError.email.message
                    : ''
                "
                has-feedback
              >
                <a-input
                  size="large"
                  v-decorator="[
                    'email',
                    {
                      rules: [
                        {
                          required: true,
                          message: 'Data username harus diisi!'
                        }
                      ]
                    }
                  ]"
                  placeholder="masukkan username"
                  :style="{ height: '45px' }"
                  :disabled="submitButton.loading"
                  allow-clear
                >
                  <a-icon
                    slot="prefix"
                    type="user"
                    :style="{ color: 'rgba(0,0,0,.5)' }"
                  />
                </a-input>
              </a-form-item>
              <a-form-item
                :style="{ marginBottom: '0px' }"
                :validate-status="
                  localError.password
                    ? 'error'
                    : serverError.password
                    ? 'error'
                    : ''
                "
                :help="
                  serverError.password
                    ? serverError.password[0]
                    : localError.password
                    ? localError.password.message
                    : ''
                "
                has-feedback
              >
                <a-input
                  size="large"
                  type="password"
                  v-decorator="[
                    'password',
                    {
                      rules: [
                        {
                          required: true,
                          message: 'Data password harus diisi'
                        }
                      ]
                    }
                  ]"
                  placeholder="masukkan password.."
                  :style="{ height: '45px' }"
                  allow-clear
                  :disabled="submitButton.loading"
                >
                  <a-icon
                    slot="prefix"
                    type="key"
                    :style="{ color: 'rgba(0,0,0,.5)' }"
                  />
                </a-input>
              </a-form-item>
              <a-form-item :style="{ marginTop: '10px' }">
                <a-button
                  type="primary"
                  html-type="submit"
                  size="large"
                  block
                  :style="{ height: '50px' }"
                  :loading="submitButton.loading"
                  >{{ submitButton.text }}</a-button
                >
                <a-divider
                  :style="{ margin: '10px 0px 10px 0px', fontSize: '14px' }"
                  >Atau</a-divider
                >
                <a-button
                  size="large"
                  block
                  :style="{ height: '50px' }"
                  @click="goIndex"
                >
                  Halaman Utama
                </a-button>
              </a-form-item>
            </a-form>
          </a-col>
        </a-row>
      </a-card>
    </a-row>
  </div>
</template>
<script>
import { mapActions } from "vuex";

export default {
  data() {
    return {
      form: "",
      localError: [],
      serverError: [],
      submitButton: {
        text: "Masuk Sistem",
        loading: false
      }
    };
  },
  head() {
    return {
      title: "Masuk Pusat Bisnis SMKN 1 Purwosari",
      meta: [
        {
          hid: "description",
          name: "description",
          content: "Masuk sistem Pusat Bisnis SMKN 1 Purwosari"
        }
      ]
    };
  },
  created() {
    this.form = this.$form.createForm(this);
  },
  methods: {
    ...mapActions("auth", ["login"]),
    handleSubmit(e) {
      e.preventDefault();
      this.form.validateFields(async (err, value) => {
        if (!err) {
          this.submitButton.text = " Autentikasi...";
          this.submitButton.loading = true;

          try {
            await this.login(value);
            //  redirect to page jurusan
            this.$router.push({ name: "dashboard" });
          } catch (error) {
            let errMsg = "";

            this.submitButton.text = "Masuk Sistem";
            this.submitButton.loading = false;

            //  check when error 422 from server
            if (error.status === 422) {
              this.serverError = error.data.errors;
            } else {
              //  check when error message user not found in system
              if (error.message === "not_found") {
                errMsg = "Username dan password tidak terdaftar di sistem!";
              }

              //  check when server API not connected
              if (error !== "undefined") {
                this.$notification.error({
                  message: "Kesalahan",
                  description: errMsg
                });
              }
            }
          }
        } else {
          //  set local error from async-validator
          this.localError = err;
        }
      });
    },
    goIndex() {
      window.location = "http://smknpurbisnis.com";
    }
  }
};
</script>
