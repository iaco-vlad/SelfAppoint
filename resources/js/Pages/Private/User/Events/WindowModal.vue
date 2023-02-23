<template>
    <div class="modal" :class="{'show-modal': showModal}" id="createWindowModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createWindowModalLabel">Create Window</h5>
                    <button type="button" @click="handleClose">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-wrapper" method="post" @submit.prevent="handleSubmit">
                        <div class="input-wrapper">

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

                            <p class="text-danger" v-if="error">{{ error }}</p>
                        </div>

                        <div class="flex items-center justify-between mb-5">
                            <button class="btn btn-secondary py-2 px-4 mx-auto my-4 rounded d-block" type="submit">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "WindowModal",
    props: {
        showModal: Boolean,
    },
    data() {
        return {
            formData: {
                user_id: this.$store.state.user.id,
                service_id: 999,
                date: '',
                time: '',
                description: 'Window',
            },
            error: '',
        };
    },
    methods: {
        handleSubmit() {
            this.resetErrors();
            if (this.validateForm()) {
                this.submitForm();
            }
        },
        submitForm() {
            axios.post('/api/events', this.formData).then(response => {
                this.$emit('window-created', response.data);

                this.formData.date = '';
                this.formData.time = '';

                this.errors = {}
            }).catch(error => {
                console.error(error);
            });
        },

        resetErrors() {
            this.error = '';
        },

        handleClose() {
            this.$emit('close');
        },

        validateForm() {
            return !(this.date === '' || this.time === '');
        }
    },
}
</script>
