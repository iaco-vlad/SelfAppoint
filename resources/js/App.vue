<template>
  <div>
    Test
    <router-link to="/login">Go to Login</router-link>
    <!-- <router-link to="/home">Go to Home</router-link> -->

    <router-view></router-view>

    <div id="id">
      <!-- <page-header /> -->
    </div>

    <!-- <page-content /> -->

    <!-- <page-footer /> -->
  </div>
</template>

<script>
export default {
  mounted() {
    console.log(this.$route.params);
    console.log('Component mounted.')
  }
}
</script>

<style>

</style>