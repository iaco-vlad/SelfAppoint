<template>
    <header class="header">
        <div class="header-home">
            <router-link :to="{name: 'home'}">Self Appoint</router-link>
        </div>

        <div class="header-profile">
            <span v-if="isAuthenticated">{{ userName }}</span>

            <img :src="profileImage" class="header-profile-image mx-2" @click="toggleDropdown" alt="Profile image">

            <ul class="header-profile-dropdown" v-show="dropdownOpen">
                <template v-if="isAuthenticated">
                    <li><router-link :to="{name: 'user.profile'}">Profile</router-link></li>

                    <li><router-link :to="{name: 'user.events'}">Events</router-link></li>

                    <li><a href="/login" @click.prevent="handleSignOut">Sign Out</a></li>
                </template>

                <template v-else>
                    <li><a href="/login" @click.prevent="handleSampleLogin">Sample login</a></li>

                    <li><router-link :to="{name: 'login'}">Login</router-link></li>

                    <li><router-link :to="{name: 'register'}">Register</router-link></li>
                </template>
            </ul>
        </div>
    </header>
</template>

<script>
import axios from "axios";

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
        handleSignOut() {
            this.backendLogout();
            this.$store.dispatch('logout');
            this.$router.push({name: 'login'});
        },
        handleSampleLogin() { // This is for testing purposes only
            try {
                const sampleLoginCredentials = {
                    email: 'randomemailname@vlad-iacovenco.com',
                    password: 'OhNoNowYouKnowAllMyPasswords1'
                };
                axios.post('/api/auth/login', sampleLoginCredentials)
                    .then(response => {
                        const credentials = {
                            token: response.data.token,
                            user: response.data.user,
                        };
                        this.$store.dispatch('setLoginCredentials', credentials);
                        this.$router.push({name: 'user.profile'});
                    })
                    .catch(error => {
                        this.error = error.data.validationError;
                    });
            } catch (error) {
                console.error(error);
            }
        },
        backendLogout() {
            axios.post('/api/auth/logout').then(response => {
                console.log(response.data.message);
            }).catch(error => {
                console.error(error);
            });
        }
    },
    computed: {
        profileImage() {
            return this.isAuthenticated
                ? profileImages.authenticated
                : profileImages.unauthenticated;
        },
        isAuthenticated() {
            return !!this.$store.getters.isAuthenticated;
        },
        userName() {
            return this.$store.state.user.name;
        },
    },
};
</script>
