<template>
  <section class="contact">
    <div class="contact-header">
      <img src="~/assets/image/kontak.jpg" alt="" />
      <div class="info">
        SMK NEGERI 1 PURWOSARI
      </div>
    </div>
    <div class="content container">
      <div class="columns">
        <div class="column is-4">
          <img src="~/assets/image/map.png" alt="" />
        </div>
        <div class="column">
          <h3>Hubungi Kami :</h3>
          <p>
            SMK Negeri 1 Purwosari merupakan salah satu lembaga pendidikan yang
            memiliki visi untuk membentuk tamatan yang beriman dan bertaqwa
            kepada Tuhan Yang Maha Esa, memiliki budi pekerti luhur,
            ketrampilan, berdaya saing tinggi dan berwawasan lingkungan<br /><br />
            <strong>Alamat Sekolah :</strong><br />
            Jl. Raya Purwosari Pasuruan Kab. Pasuruan Provinsi JawaTimur<br />
            Telp. 0343-613747
          </p>
          <div class="map">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.2080910372338!2d112.74608131420992!3d-7.767744679199309!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7d3c663e7e67b%3A0x4ea808ba51708c66!2sSMK%20Negeri%201%20Purwosari!5e0!3m2!1sen!2sid!4v1587444671995!5m2!1sen!2sid"
              width="600"
              height="450"
              frameborder="0"
              style="border: 0;"
              allowfullscreen=""
              aria-hidden="false"
              tabindex="0"
            ></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
export default {
  head() {
    return {
      title: "Hubungi Kami",
      meta: [
        {
          hid: "description",
          name: "description",
          content: "Hubungi SMKN 1 Purwosari",
        },
      ],
    };
  },
};
</script>
