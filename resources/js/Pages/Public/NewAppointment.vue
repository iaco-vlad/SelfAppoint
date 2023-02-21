<template>
    <div class="shadow-lg text-center">
        <h1 class="pt-5 pb-3"> Make an Appointment </h1>

        <span>with</span>
        <h3 class="py-3">{{ administrator.name }} ( {{ administrator.title }} )</h3>

        <p v-if="createdAppointmentSuccessfully" class="pb-5">You just made an appointment. You'll receive a
            confirmation or rejection email from
            {{ administrator.name }} as soon as they respond.</p>

        <form class="form-wrapper" method="post" @submit.prevent="handleSubmit" v-else>
            <div class="input-wrapper">
                <div class="mb-4" v-if="!user">
                    <label class="w-50" for="phone_number">
                        Phone number
                    </label>
                    <input class="shadow border rounded py-2 px-3" id="phone_number"
                           type="text" v-model="formData.phoneNumber" required/>
                    <div>
                        or
                        <router-link :to="{name: 'login'}">Login</router-link>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="w-50" for="service">
                        Service
                    </label>
                    <select class="form-input shadow border rounded py-2 px-3" id="service"
                            v-model="formData.service_id" required>
                        <option v-for="service in services" :key="service.id" :value="service.id">
                            {{ fullServiceName(service) }}
                        </option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="w-50" for="date">
                        Date
                    </label>
                    <input class="form-input shadow border rounded py-2 px-3" id="date" type="date"
                           v-model="formData.date" required/>
                </div>

                <div class="mb-4">
                    <label class="w-50" for="time">
                        Time
                    </label>
                    <input class="form-input shadow border rounded py-2 px-3" id="time" type="time"
                           v-model="formData.time" required/>
                </div>

                <div class="mb-4">
                    <label class="w-50" for="description">
                        Additional information
                    </label>
                    <input class="form-input shadow border rounded py-2 px-3" id="description"
                           v-model="formData.description"/>
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
import axios from "axios";

export default {
    data() {
        return {
            formData: {
                phone_number: '',
                service_id: '',
                date: '',
                time: '',
                description: '',
            },
            services: [],
            error: '',
            administrator: {},
            createdAppointmentSuccessfully: false,
        };
    },
    mounted() {
        this.loadAdministratorInformation();

    },
    methods: {

        handleSubmit() {
            this.resetErrors();
            this.submitForm();
        },
        async submitForm() {
            try {
                const requestData = {
                    administrator_id: this.administratorId,
                    service_id: this.formData.service_id,
                    date: this.formData.date,
                    time: this.formData.time,
                    description: this.user ? this.formData.description
                        : `Anonymous appointment. Phone number: ${this.formData.phone_number}. Additional infomration: ${this.formData.description}`,
                }
                axios.post(`/api/events`, requestData)
                    .then(() => {
                        this.createdAppointmentSuccessfully = true;
                    })
                    .catch(error => {
                        console.error(error);
                        this.error = 'Failed to create appointment.';
                    });
            } catch (error) {
                console.error(error);
            }
        },
        loadAdministratorInformation() {
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
        fullServiceName(service) {
            if (service.show_timespan) {
                return `${service.name} (${service.timespan} min)`;
            }
            return service.name
        },
        resetErrors() {
            this.error = '';
        },
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
