<template>
    <header class="header">
        <div class="header-home">
            <router-link :to="{name: 'home'}">Self Appoint</router-link>
        </div>

        <div class="header-profile">
            <img :src="profileImage" class="header-profile-image" @click="toggleDropdown">

            <ul class="header-profile-dropdown" v-show="dropdownOpen">
                <template v-if="isAuthenticated">
                    <li><router-link :to="{name: 'user.profile'}">Profile</router-link></li>

                    <li><router-link :to="{name: 'user.events'}">Events</router-link></li>
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
export default {
    name: 'AppHeader',
    data() {
        return {
            isAuthenticated: false, // TODO: Update
            dropdownOpen: false,
            profileImage: '/images/avatar-placeholder.jpeg' // Replace with actual profile image URL
        };
    },
    methods: {
        toggleDropdown() {
            this.dropdownOpen = !this.dropdownOpen;
        }
    }
};
</script>
