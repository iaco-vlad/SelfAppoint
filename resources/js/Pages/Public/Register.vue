<template>
    <div class="shadow-lg text-center">
        <h1 class="py-5"> Register </h1>

        <h3 v-if="registeredSuccessfully" class="pb-5">Form submitted. Check your email to complete the registration.</h3>

        <form class="form-wrapper" method="post" @submit.prevent="handleSubmit" v-else>
            <div class="input-wrapper">
                <div class="mb-4">
                    <label class="w-50" for="name">
                        Name
                    </label>
                    <input class="shadow border rounded py-2 px-3" id="name"
                           type="text" v-model="formData.name" required/>
                </div>

                <div class="mb-4">
                    <label class="w-50" for="title">
                        Title
                    </label>
                    <input class="shadow border rounded py-2 px-3" id="title"
                           type="text" v-model="formData.title" required/>
                </div>

                <div class="mb-4">
                    <label class="w-50" for="phone_number">
                        Phone number
                    </label>
                    <input class="shadow border rounded py-2 px-3" id="phone_number"
                           type="text" v-model="formData.phoneNumber" required/>
                </div>

                <div class="mb-4">
                    <label class="w-50" for="username">
                        Email Address
                    </label>
                    <input class="shadow border rounded py-2 px-3" id="username"
                           type="text" v-model="formData.email" required/>
                </div>

                <div class="mb-4">
                    <label class="w-50" for="password">
                        Password
                    </label>
                    <input
                        class="shadow border rounded py-2 px-3 mb-3"
                        id="password" type="password" v-model="formData.password" required/>
                </div>

                <p class="text-danger" v-if="error">{{ error }}</p>
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
import {emailValidator, nameValidator, titleValidator, passwordValidator, phoneNumberValidator} from "@/Utils/validators";

export default {
    data() {
        return {
            formData: {
                name: '',
                title: '',
                phone_number: '',
                email: '',
                password: '',
            },
            error: '',
            registeredSuccessfully: false
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
            if (!nameValidator.regex.test(this.formData.name)) {
                this.error = nameValidator.message;
                return false;
            }
            if (!titleValidator.regex.test(this.formData.title)) {
                this.error = titleValidator.message;
                return false;
            }
            if (!(this.formData.phone_number === '' || phoneNumberValidator.regex.test(this.formData.phone_number))) {
                this.error = phoneNumberValidator.message;
                return false;
            }
            if (!emailValidator.regex.test(this.formData.email)) {
                this.error = emailValidator.message;
                return false;
            }
            if (!passwordValidator.regex.test(this.formData.password)) {
                this.error = passwordValidator.message;
                return false;
            }
            return true;
        },

        async submitForm() {
            try {
                axios.post('/api/auth/signup', this.formData)
                    .then(() => {
                        this.registeredSuccessfully = true;
                    })
                    .catch(error => {
                        console.error(error);
                        this.error = error.data.response.validationError;
                    });
            } catch (error) {
                console.error(error);
            }
        },

        resetErrors() {
            this.error = '';
        },
    }
}
</script>
