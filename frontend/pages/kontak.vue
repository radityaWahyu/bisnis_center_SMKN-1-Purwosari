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
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum
            explicabo in ex atque, ullam veniam culpa eligendi. Quae
            necessitatibus perspiciatis mollitia quia laborum ratione voluptatum
            dolorem minima similique aperiam nobis, quisquam aut omnis sit ad
            tempore dolores enim rerum tempora.
          </p>
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
