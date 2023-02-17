<template>
    <div class="shadow-lg text-center">
        <h1 class="pt-5 pb-3"> Make an Appointment </h1>

        <span>with</span><h3 class="py-3">{{ administrator.name }} ( {{ administrator.title }} )</h3>

        <form class="form-wrapper" method="post" @submit.prevent="handleSubmit">
            <div class="input-wrapper">
                <div class="mb-4" v-if="!user">
                    <label class="w-50" for="phone_number">
                        Phone number
                    </label>
                    <input class="shadow border rounded py-2 px-3" id="phone_number"
                           type="text" v-model="formData.phoneNumber" required/>
                    <div>
                        or <router-link :to="{name: 'login'}">Login</router-link>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="w-50" for="service">
                        Service
                    </label>
                    <select class="form-input shadow border rounded py-2 px-3" id="service" v-model="formData.service_id" required>
                        <option v-for="service in services" :key="service.id" :value="service.id">
                            {{ fullServiceName(service) }}
                        </option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="w-50" for="date">
                        Date
                    </label>
                    <input class="form-input shadow border rounded py-2 px-3" id="date" type="date" v-model="formData.date" required/>
                </div>

                <div class="mb-4">
                    <label class="w-50" for="time">
                        Time
                    </label>
                    <input class="form-input shadow border rounded py-2 px-3" id="time" type="time" v-model="formData.time" required/>
                </div>

                <div class="mb-4">
                    <label class="w-50" for="description">
                        Additional information
                    </label>
                    <input class="form-input shadow border rounded py-2 px-3" id="description" v-model="formData.description"
                           required/>
                </div>

                <p class="text-danger" v-if="error">{{ error }}</p>
            </div>

            <div class="flex items-center justify-between mb-5">
                <button class="btn btn-secondary py-2 px-4 mx-auto my-4 rounded d-block" type="submit">
                    Submit
                </button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            formData: {
                service_id: '',
                date: '',
                description: '',
            },
            services: [],
            error: null,
            administrator: {},
        };
    },
    mounted() {
        this.loadUserInformation();

    },
    methods: {
        loadUserInformation() {
            axios.get('/api/users/' + this.administratorId)
                .then(response => {
                    this.administrator = response.data.user;
                    this.loadServices();
                })
                .catch(error => {
                    console.error(error);
                    this.error = 'Failed to load the administrator.';
                });
        },
        loadServices() {
            axios.get(`/api/services?administrator_id=` + this.administratorId)
                .then(response => {
                    this.services = response.data.services;
                })
                .catch(error => {
                    console.error(error);
                    this.error = 'Failed to load services.';
                });
        },
        handleSubmit() {
            this.error = null;

            axios.post(`/api/${this.administratorId}/appointments`, this.formData)
                .then(() => {
                    this.$router.push({name: 'dashboard'});
                })
                .catch(error => {
                    console.error(error);
                    this.error = 'Failed to create appointment.';
                });
        },
        fullServiceName(service) {
            if (service.show_timespan) {
                return `${service.name} (${service.timespan} min)`;
            }
            return service.name
        }
    },

    computed: {
        administratorId() {
            return this.$route.params.administratorId;
        },
        user() {
            return this.$store.state.user;
        },
    },
};
</script>
