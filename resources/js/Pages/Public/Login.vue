<template>
    <div class="shadow-lg text-center">
        <h1 class="py-5"> Login </h1>

        <form class="form-wrapper" method="post" @submit.prevent="handleSubmit">
            <div class="input-wrapper">
                <div class="mb-4">
                    <label class="w-50" for="username">
                        Email Address
                    </label>
                    <input class="shadow border rounded py-2 px-3" id="username"
                           type="text" v-model="form.email" required/>
                </div>

                <div class="mb-4">
                    <label class="w-50" for="password">
                        Password
                    </label>
                    <input
                        class="shadow border rounded py-2 px-3 mb-3"
                        id="password" type="password" v-model="form.password" required/>
                </div>

                <p class="text-danger" v-if="error">{{ error }}</p>
            </div>

            <div class="flex items-center justify-between mb-5">
                <button class="btn btn-secondary py-2 px-4 mx-auto my-4 rounded d-block" type="submit">
                    Sign In
                </button>

                <span class="small">or click here to</span>

                <router-link :to="{name: 'register'}">
                    <button class="btn btn-outline-primary py-2 px-3 rounded mx-2 border-0" type="button">
                        Register
                    </button>
                </router-link>
            </div>
        </form>
    </div>
</template>

<script>
import {emailValidator, passwordValidator} from "@/Utils/validators";
import axios from "axios";

export default {
    data() {
        return {
            form: {
                email: '',
                password: '',
            },
            error: '',
        }
    },
    mounted() {
        if (this.$store.getters.isAuthenticated) {
            this.$router.push({name: 'user.profile'});
        }
    },
    methods: {
        handleSubmit() {
            this.resetErrors();
            if (this.validateForm()) {
                this.submitForm();
            }
        },

        validateForm() {
            if (!passwordValidator.regex.test(this.form.password)) {
                this.error = passwordValidator.message;
                return false;
            }
            if (!emailValidator.regex.test(this.form.email)) {
                this.error = emailValidator.message;
                return false;
            }
            return true;
        },

        async submitForm() {
            try {
                axios.post('/api/auth/login', this.form)
                    .then(response => {
                        const credentials = {
                            token: response.data.token,
                            user: response.data.user,
                        };
                        this.$store.dispatch('setLoginCredentials', credentials);
                        this.$router.push({name: 'user.profile'});
                    })
                    .catch(error => {
                        this.error = error.response.data.validationError;
                        console.error(error)
                    });
            } catch (error) {
                console.error(error);
            }
        },

        resetErrors() {
            this.error = '';
        },
    },
}
</script>
