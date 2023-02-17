<template>
    <div class="text-center">
        <h1 class="py-5 mr-auto"> Profile </h1>

        <form class="form-wrapper" @submit.prevent="handleSubmit">
            <div class="input-wrapper">
                <div class="mb-4">
                    <label class="w-50" for="name">Name</label>
                    <input type="text" class="shadow border rounded py-2 px-4" id="name" v-model="formData.name">
                </div>
                <div class="mb-4">
                    <label class="w-50" for="title">Title</label>
                    <input type="text" class="shadow border rounded py-2 px-4" id="title" v-model="formData.title">
                </div>
                <div class="mb-4">
                    <label class="w-50" for="phone_number">Phone number</label>
                    <input type="text" class="shadow border rounded py-2 px-4" id="phone_number" v-model="formData.phone_number">
                </div>
                <div class="mb-4">
                    <label class="w-50" for="password">New password</label>
                    <input type="password" class="shadow border rounded py-2 px-4" id="password" v-model="formData.password">
                </div>
                <p class="text-danger" v-if="error">{{ error }}</p>
                <p class="text-success" v-if="success">{{ success }}</p>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Save</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import {
    nameValidator,
    passwordValidator,
    phoneNumberValidator,
    titleValidator
} from "@/Utils/validators";

export default {
    data() {
        return {
            formData: {
                name: '',
                password: '',
                phone_number: '',
                title: '',
            },
            error: '',
            success: '',
        };
    },
    computed: {
        user() {
            return this.$store.state.user;
        },
    },
    mounted() {
        this.fetchUser();
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
            if (!(this.formData.password === '' || this.formData.password === null || passwordValidator.regex.test(this.formData.password))) {
                this.error = passwordValidator.message;
                return false;
            }
            return true;
        },

        async submitForm() {
            try {
                axios.put('/api/users/' + this.user.id, this.formData)
                    .then(() => {
                        this.success = 'Profile update successfully.';
                        this.fetchUser()
                    })
                    .catch(error => {
                        this.error = error.response.data.validationError;
                    });
            } catch (error) {
                console.error(error);
            }
        },

        resetErrors() {
            this.error = '';
            this.success = '';
        },

        fetchUser() {
            try {
                axios.get('/api/users/' + this.user.id)
                    .then(response => {
                    console.log(response.data.user)
                        this.formData.name = response.data.user.name;
                        this.formData.title = response.data.user.title;
                        this.formData.phone_number = response.data.user.phone_number;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            } catch (error) {
                console.error(error);
            }
        }
    },
};
</script>

