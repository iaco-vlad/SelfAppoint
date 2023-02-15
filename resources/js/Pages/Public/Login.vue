<template>
        <div class="login-section shadow-lg">
            <h1 class="py-5"> Login </h1>

            <ul class="list-disc text-red-400" v-for="(value, index) in errors" :key="index"
                v-if="typeof errors === 'object'">
                <li>{{ value[0]}}</li>
            </ul>

            <p class="list-disc text-red-400" v-if="typeof errors === 'string'">{{ errors }}</p>

            <form method="post" @submit.prevent="handleLogin">
                <div class="login-input-wrapper">
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

import { ref, reactive } from 'vue';
import { useRouter } from 'vue-router';
export default {
    setup() {
        const errors = ref()
        const router = useRouter();
        const form = reactive({
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
    }
}
</script>
