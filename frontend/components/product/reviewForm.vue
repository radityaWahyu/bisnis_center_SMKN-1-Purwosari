<template>
  <b-modal
    :active.sync="show"
    :can-cancel="false"
    has-modal-card
    trap-focus
    aria-role="dialog"
    aria-modal
  >
    <div class="modal-card" style="width: 400px;">
      <ValidationObserver
        ref="observer"
        v-slot="{ invalid }"
        tag="form"
        @submit.prevent="onSubmit"
      >
        <header class="modal-card-head">
          <p class="modal-card-title">Form Ulasan</p>
        </header>
        <section class="modal-card-body">
          <ValidationProvider
            rules="required"
            v-slot="{ valid, errors }"
            :customMessages="{
              required: `Nama Lengkap harus diisi`,
            }"
          >
            <b-field
              label="Nama Lengkap"
              :type="{ 'is-danger': errors[0], 'is-success': valid }"
              :message="errors"
              class="form-input"
            >
              <b-input
                v-model="name"
                placeholder="Masukkan nama anda"
                type="text"
              />
            </b-field>
          </ValidationProvider>
          <ValidationProvider
            rules="required"
            v-slot="{ valid, errors }"
            :customMessages="{
              required: `No. Telp / Handphone harus diisi`,
            }"
          >
            <b-field
              label="No Handphone / Telepon"
              :type="{ 'is-danger': errors[0], 'is-success': valid }"
              :message="errors"
              class="form-input"
            >
              <b-input
                type="number"
                v-model="phone"
                placeholder="Masukkan No Telp / Handphone"
                required
              />
            </b-field>
          </ValidationProvider>
          <b-field label="Ulasan" class="form-input">
            <b-input
              v-model="message"
              type="textarea"
              minlength="6"
              maxlength="200"
              placeholder="Tulis ulasan..."
            >
            </b-input>
          </b-field>
        </section>
        <footer class="modal-card-foot">
          <b-button
            expanded
            @click="onClose"
            :style="{ width: '100%' }"
            :disabled="loading"
          >
            Batalkan
          </b-button>
          <b-button
            type="is-primary"
            :disabled="invalid"
            :loading="loading"
            native-type="submit"
            expanded
          >
            Kirim Ulasan
          </b-button>
        </footer>
      </ValidationObserver>
    </div>
  </b-modal>
</template>
<script>
export default {
  props: {
    id: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      show: false,
      name: "",
      phone: "",
      message: "",
      loading: false,
    };
  },
  methods: {
    showForm(data) {
      this.show = data;
    },
    async onSubmit() {
      try {
        this.loading = true;
        await this.$store.dispatch("review/sendReview", {
          nama: this.name,
          phone: this.phone,
          pesan: this.message,
          item: this.id,
        });
        this.clearForm();
        this.show = false;
        this.$emit("success", true);
      } catch (error) {
        console.log(error);
      }
      this.loading = false;
    },
    onClose() {
      this.clearForm();
      this.show = false;
    },
    clearForm() {
      this.name = null;
      this.phone = null;
      this.message = null;
    },
  },
};
</script>
