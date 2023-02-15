<template>
  <div>
    <app-header />

      <router-view />

     <app-footer />
  </div>
</template>

<script>
import AppContent from './Components/Content/Content.vue';
import AppFooter from './Components/Footer/Footer.vue';
import AppHeader from './Components/Header/Header.vue';

export default {
  components: {
    AppContent,
    AppFooter,
    AppHeader,
  },

  mounted() {
    console.log(this.$route.params);
    console.log('Component mounted.')
  }
}
</script>

<style>

</style>
