<template>
  <v-app id="login">
    <nuxt />
  </v-app>
</template>

<script>
export default {
  head: {
    title: "",
  },
  components: {},
  data() {
    return {};
  },
  computed: {},
  async asyncData({ params, axios }) {},
  mounted() {},
  methods: {},
};
</script>

<style>
#login {
  background-image: url("~@/assets/image/login.jpg");
  background-size: cover;
  background-position: top center;
  height: 100vh;
}
</style>
