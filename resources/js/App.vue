<template>
    <div>
        <app-header/>

        <router-view/>

        <app-footer/>
    </div>
</template>

<script>
import AppFooter from './Components/Footer/Footer.vue';
import AppHeader from './Components/Header/Header.vue';

export default {
    components: {
        AppFooter,
        AppHeader,
    },
}
</script>
