<template>
  <a-form :form="form" layout="vertical" :style="{ padding: '0px' }">
    <a-row justify="space-between" type="flex" :gutter="24">
      <a-col :span="7">
        <a-alert
          message="Keterangan :"
          type="info"
          :style="{ marginBottom: '10px', border: 'none' }"
          v-if="type !== 'profil'"
        >
          <p slot="description">
            - <strong>Administrator</strong> level tertinggi dari sistem untuk
            mengolah semua fitur di dalam sistem.<br />
            - <strong>Operator</strong> level user setiap operator jurusan untuk
            mengolah semua beberapa fitur di dalam sistem.
          </p>
        </a-alert>
        <img
          :src="image"
          alt=""
          width="305px"
          height="320px"
          v-if="image.length > 0"
          class="image-profil"
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
      </a-col>
      <a-col :span="17">
        <a-form-item
          label="Nama User"
          :style="{ marginBottom: '10px' }"
          has-feedback
          :validate-status="
            localError.name ? 'error' : serverError.name ? 'error' : ''
          "
          :help="
            serverError.name
              ? serverError.name[0]
              : localError.name
              ? localError.name.message
              : 'Masukkan nama lengkap user yang di daftarkan.'
          "
        >
          <a-input
            size="large"
            v-decorator="[
              'name',
              {
                rules: [
                  {
                    required: true,
                    message: 'Data nama harus diisi!'
                  }
                ]
              }
            ]"
            allowClear
          >
            <a-icon slot="prefix" type="user" />
          </a-input>
        </a-form-item>
        <a-row :gutter="16">
          <a-col :span="12">
            <a-form-item
              label="Email"
              :style="{ marginBottom: '10px' }"
              has-feedback
              :validate-status="
                localError.email ? 'error' : serverError.email ? 'error' : ''
              "
              :help="
                serverError.email
                  ? serverError.email[0]
                  : localError.email
                  ? localError.email.message
                  : 'Email dipergunakan untuk login user.'
              "
            >
              <a-input
                size="large"
                v-decorator="[
                  'email',
                  {
                    rules: [
                      {
                        required: true,
                        message: 'Email harus diisi!'
                      }
                    ]
                  }
                ]"
                allowClear
              >
                <a-icon slot="prefix" type="mail" />
              </a-input>
            </a-form-item>
          </a-col>
          <a-col :span="12">
            <a-form-item
              label="Handphone Aktif"
              :style="{ marginBottom: '10px' }"
              has-feedback
              :validate-status="
                localError.phone ? 'error' : serverError.phone ? 'error' : ''
              "
              :help="
                serverError.phone
                  ? serverError.phone[0]
                  : localError.phone
                  ? localError.phone.message
                  : 'Masukkan no whatsapp atau handpohne aktif agar bisa dihubungin.'
              "
            >
              <a-input
                size="large"
                v-decorator="[
                  'phone',
                  {
                    rules: [
                      {
                        required: true,
                        message: 'No Handphone harus diisi!'
                      }
                    ]
                  }
                ]"
                allowClear
              >
                <a-icon slot="prefix" type="phone" />
              </a-input>
            </a-form-item>
          </a-col>
        </a-row>
        <a-row :gutter="16">
          <a-col :span="10">
            <a-form-item
              :style="{ marginBottom: '5px', marginTop: '5px' }"
              label="Level user"
              :validate-status="
                localError.level ? 'error' : serverError.level ? 'error' : ''
              "
              :help="
                serverError.level
                  ? serverError.level[0]
                  : localError.level
                  ? localError.level.message
                  : ''
              "
              has-feedback
            >
              <a-select
                v-if="type !== 'profil'"
                size="large"
                v-decorator="[
                  'level',
                  {
                    rules: [
                      {
                        required: true,
                        message: 'Pilih level terlebih dahulu'
                      }
                    ]
                  }
                ]"
                placeholder="Pilih level user"
                @change="onChangeLevel"
              >
                <a-select-option value="admin">
                  Administrator
                </a-select-option>
                <a-select-option value="operator">
                  Operator
                </a-select-option>
              </a-select>
              <a-input v-else size="large" v-decorator="['level']" read-only>
                <a-icon slot="prefix" type="branches" />
              </a-input>
            </a-form-item>
          </a-col>
          <a-col :span="14">
            <a-form-item
              :style="{ marginBottom: '5px', marginTop: '5px' }"
              label="Jurusan"
              has-feedback
            >
              <a-select
                v-if="type !== 'profil'"
                size="large"
                v-decorator="['jurusan']"
                placeholder="Pilih Jurusan"
                :disabled="level !== 'operator'"
              >
                <a-select-option v-for="row in jurusan" :key="row.id">
                  {{ row.departement }}
                </a-select-option>
              </a-select>
              <a-input v-else size="large" v-decorator="['jurusan']" read-only>
                <a-icon slot="prefix" type="deployment-unit" />
              </a-input>
            </a-form-item>
          </a-col>
        </a-row>
        <a-form-item
          label="Password"
          :style="{ marginBottom: '10px' }"
          has-feedback
          :validate-status="
            localError.password ? 'error' : serverError.password ? 'error' : ''
          "
          :help="
            serverError.password
              ? serverError.password[0]
              : localError.password
              ? localError.password.message
              : 'Masukkan password minimal 6 digit'
          "
        >
          <a-input-password
            v-if="edit"
            size="large"
            type="password"
            v-decorator="['password']"
          >
            <a-icon slot="prefix" type="key" />
          </a-input-password>
          <a-input-password
            v-else
            size="large"
            type="password"
            v-decorator="[
              'password',
              {
                rules: [
                  {
                    required: true,
                    message: 'Password harus diisi!'
                  }
                ]
              }
            ]"
          >
            <a-icon slot="prefix" type="key" />
          </a-input-password>
        </a-form-item>
      </a-col>
    </a-row>
  </a-form>
</template>
<script>
import { mapActions, mapMutations } from "vuex";

export default {
  props: {
    id: {
      type: String,
      required: false
    },
    type: {
      type: String,
      required: false
    }
  },
  data() {
    return {
      loader: [],
      uploadImage: "",
      image: "",
      imageFile: [],
      jurusan: [],
      serverError: [],
      localError: [],
      listValidate: "",
      level: "",
      edit: false
    };
  },
  created() {
    // console.log(ClassicEditor.defaultConfig.toolbar);
    this.form = this.$form.createForm(this);
  },
  watch: {
    id: {
      deep: true,
      immediate: true,
      handler(value) {
        this.getList();

        if (value !== undefined) {
          this.getUser(value);
        }
      }
    }
  },
  methods: {
    ...mapMutations("spinner", ["set_spinner"]),
    ...mapActions("departement", ["getListDepartement"]),
    ...mapActions("user", ["createUser", "showUser"]),
    async getUser(id) {
      this.set_spinner({ show: true, text: "Ambil Data..." });
      try {
        const { data } = await this.showUser(id);
        // console.log(data);
        let departement = "";

        if (this.type !== "profil") {
          departement = data.departement_id;
        } else if (data.departement_name.length === 0) {
          departement = "Administrator Sistem";
        } else {
          departement = data.departement_name;
        }

        // console.log(data);
        setTimeout(() => {
          this.form.setFieldsValue({
            jurusan: departement,
            name: data.name,
            email: data.email,
            level: data.level,
            phone: data.phone
          });
          this.level = data.level;
          this.edit = true;
        }, 0);
        this.editorData = data.content;
        if (data.image !== null) {
          this.image = process.env.IMAGE_URL + "/thumbnail/user/" + data.image;
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
    saveUser() {
      this.form.validateFields(async (err, value) => {
        if (!err) {
          if (this.image.length === 0) {
            this.$notification.error({
              message: "Kesalahan",
              description: "Gambar user belum di pilih"
            });
          } else {
            console.log(value.level);
            this.set_spinner({ show: true, text: "Menyimpan..." });
            try {
              const fd = new FormData();
              fd.append("nama", value.name);
              fd.append("email", value.email);
              fd.append("phone", value.phone);
              fd.append("level", this.level);
              if (value.level === "operator") {
                fd.append("jurusan", value.jurusan);
              }
              fd.append("password", value.password);
              fd.append("image", this.imageData);

              await this.createUser(fd);
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
    updateUser() {
      this.form.validateFields(async (err, value) => {
        if (!err) {
          this.set_spinner({ show: true, text: "Menyimpan..." });
          try {
            const fdUpdate = new FormData();
            fdUpdate.append("nama", value.name);
            fdUpdate.append("email", value.email);
            fdUpdate.append("phone", value.phone);
            fdUpdate.append("level", this.level);
            if (value.level === "operator") {
              fdUpdate.append("jurusan", value.jurusan);
            }
            if (value.password !== undefined) {
              fdUpdate.append("password", value.password);
            } else {
              fdUpdate.append("password", "");
            }
            fdUpdate.append("image", this.imageData);

            // call function to update data product
            await this.$store.dispatch("user/updateUser", {
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
    updateProfil() {
      this.form.validateFields(async (err, value) => {
        if (!err) {
          this.set_spinner({ show: true, text: "Menyimpan..." });
          try {
            const fdUpdate = new FormData();
            fdUpdate.append("nama", value.name);
            fdUpdate.append("email", value.email);
            fdUpdate.append("phone", value.phone);
            if (value.password !== undefined) {
              fdUpdate.append("password", value.password);
            } else {
              fdUpdate.append("password", "");
            }
            fdUpdate.append("level", value.level);
            fdUpdate.append("image", this.imageData);

            // call function to update data product
            await this.$store.dispatch("user/updateUser", {
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
    onChangeLevel(value) {
      this.level = value;
    }
  }
};
</script>
