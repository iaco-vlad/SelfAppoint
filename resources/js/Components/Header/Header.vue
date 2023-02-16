<template>
    <header class="header">
        <div class="header-home">
            <router-link :to="{name: 'home'}">Self Appoint</router-link>
        </div>

        <div class="header-profile">
            <img :src="profileImage" class="header-profile-image" @click="toggleDropdown" alt="Profile image">

            <ul class="header-profile-dropdown" v-show="dropdownOpen">
                <template v-if="isAuthenticated">
                    <li><router-link :to="{name: 'user.profile'}">Profile</router-link></li>

                    <li><router-link :to="{name: 'user.events'}">Events</router-link></li>

                    <li><a href="/login" @click.prevent="handleSignOut">Sign Out</a></li>
                </template>

                <template v-else>
                    <li><router-link :to="{name: 'login'}">Login</router-link></li>

                    <li><router-link :to="{name: 'register'}">Register</router-link></li>
                </template>
            </ul>
        </div>
    </header>
</template>

<script>
const profileImages = {
    unauthenticated: '/images/unauthenticated-avatar-placeholder.png',
    authenticated: '/images/authenticated-avatar-placeholder.png',
};

export default {
    name: 'AppHeader',

    data() {
        return {
            dropdownOpen: false,
        };
    },
    methods: {
        toggleDropdown() {
            this.dropdownOpen = !this.dropdownOpen;
        },
        handleSignOut() {} // TODO: Update method
    },
    computed: {
        profileImage() {
            return this.isAuthenticated
                ? profileImages.authenticated
                : profileImages.unauthenticated;
        },
        isAuthenticated() {
            return !!this.$store.state.token;
        },
    },
};
</script>
