<template>
    <div class="shadow-lg text-center">
        <h1 class="py-5"> Login </h1>

        <!--            <ul class="lisc text-red-400" v-for="(value, index) in errors" :key="index"-->
        <!--                v-if="typeof errors === 'object'">-->
        <!--                <li>{{ value[0]}}</li>-->
        <!--            </ul>-->

        <!--            <p class="list-disct-dis text-red-400" v-if="typeof errors === 'string'">{{ errors }}</p>-->

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
                        class="shadow border border-red rounded py-2 px-3 mb-3"
                        id="password" type="password" v-model="form.password" required/>
                </div>
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
        }
    },
    methods: {
        handleSubmit() {
            if (this.validateForm()) {
                this.submitForm();
            } else {
                // TODO: Add the message to the errors field.
            }
        },

        validateForm() {
            return passwordValidator.test(this.form.password)
                && emailValidator.test(this.form.email);
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
                        // TODO: Redirect to the profile page once its done
                    })
                    .catch(error => {
                        // TODO: Add 'errors' variable and pin it on the bottom of the form.
                        // Update it with the value of the response in case of error.
                        console.log(error)
                    });
            } catch (error) {
                console.error(error);
            }
        },
    }
}
</script>
