<template>
    <div class="login-section shadow-lg">
        <h1 class="py-5"> Register </h1>

<!--        <ul class="list-disc text-red-400" v-for="(value, index) in errors" :key="index"-->
<!--            v-if="typeof errors === 'object'">-->
<!--            <li>{{ value[0] }}</li>-->
<!--        </ul>-->

<!--        <p class="list-disc text-red-400" v-if="typeof errors === 'string'">{{ errors }}</p>-->

        <form method="post" @submit.prevent="handleSubmit">
            <div class="login-input-wrapper">
                <div class="mb-4">
                    <label class="w-50" for="name">
                        Name
                    </label>
                    <input class="shadow border rounded py-2 px-3" id="name"
                           type="text" v-model="form.name" required/>
                </div>

                <div class="mb-4">
                    <label class="w-50" for="phone-number">
                        Phone number
                    </label>
                    <input class="shadow border rounded py-2 px-3" id="phone-number"
                           type="text" v-model="form.phoneNumber" required/>
                </div>

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
                    Sign Up
                </button>

                <span class="small">or click here to</span>

                <router-link :to="{name: 'login'}">
                    <button class="btn btn-outline-primary py-2 px-3 rounded mx-2 border-0" type="button">
                        Login
                    </button>
                </router-link>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import {emailValidator, nameValidator, passwordValidator, phoneNumberValidator} from "@/Utils/validators";

export default {
    data() {
        return {
            form: {
                name: '',
                phoneNumber: '',
                email: '',
                password: '',
            },
        }
    },

    methods: {
        handleSubmit() {
            // TODO: Send a request to the server to verify the credentials
            // console.log(`Email: ${this.form.email}. Password: ${this.form.password}`);
            return;
            if (this.validateForm()) {
                this.submitForm();
            }
        },

        validateForm() {
            return passwordValidator.test(this.form.password)
                && emailValidator.test(this.form.email)
                && (this.form.phoneNumber === '' || phoneNumberValidator.test(this.form.phoneNumber))
                && nameValidator.test(this.form.name);
        },

        async submitForm() {
            try {
                const response = await axios.post('/api/user', this.formData);
                // console.log(response.data);
            } catch (error) {
                // console.error(error);
            }
        },
    }
}
</script>
