<template>
    <div class="login-section shadow-lg">
        <h1 class="py-5"> Register </h1>

        <ul class="list-disc text-red-400" v-for="(value, index) in errors" :key="index"
            v-if="typeof errors === 'object'">
            <li>{{ value[0]}}</li>
        </ul>

        <p class="list-disc text-red-400" v-if="typeof errors === 'string'">{{ errors }}</p>

        <form method="post" @submit.prevent="handleLogin">
            <div class="login-input-wrapper">
                <div class="mb-4">
                    <label class="w-50" for="name">
                        Name
                    </label>
                    <input class="shadow border rounded py-2 px-3" id="name"
                           type="text" v-model="form.name" required />
                </div>

                <div class="mb-4">
                    <label class="w-50" for="phone-number">
                        Phone number
                    </label>
                    <input class="shadow border rounded py-2 px-3" id="phone-number"
                           type="text" v-model="form.phoneNumber" required />
                </div>

                <div class="mb-4">
                    <label class="w-50" for="username">
                        Email Address
                    </label>
                    <input class="shadow border rounded py-2 px-3" id="username"
                           type="text" v-model="form.email" required />
                </div>

                <div class="mb-4">
                    <label class="w-50" for="password">
                        Password
                    </label>
                    <input
                        class="shadow border border-red rounded py-2 px-3 mb-3"
                        id="password" type="password" v-model="form.password" required />
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
import {reactive, ref} from "vue";
import {useRouter} from "vue-router";

export default {
    setup() {
        const errors = ref()
        const router = useRouter();
        const form = reactive({
            name: '',
            phoneNumber: '',
            email: '',
            password: '',
        })
        const handleLogin = async () => {
            try {
                const result = await axios.post('/api/auth/login', form)
                if (result.status === 200 && result.data && result.data.token) {
                    localStorage.setItem('APP_DEMO_USER_TOKEN', result.data.token)
                    await router.push('home')
                }
            } catch (e) {
                if (e && e.response.data && e.response.data.errors) {
                    errors.value = Object.values(e.response.data.errors)
                } else {
                    errors.value = e.response.data.message || ""
                }
            }
        }

        return {
            form,
            errors,
            handleLogin,
        }
    },

  data() {
    return {
      email: '',
      password: ''
    }
  },

  methods: {
    login() {
      // TODO: Send a request to the server to verify the credentials
      console.log(`Email: ${this.email} Password: ${this.password}`);
    },

    validator() {
        return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/.test(this.password)
            && /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(this.email);
    },

    async submitForm() {
      try {
        const response = await axios.post('/api/user/', this.formData);
        console.log(response.data);
      } catch (error) {
        console.error(error);
      }
    },
  }
}
</script>
