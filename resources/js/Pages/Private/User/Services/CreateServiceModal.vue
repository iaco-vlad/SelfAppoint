<template>
    <div>
        <!-- Create Service Modal -->
        <div class="modal" :class="{'show-modal': showModal}" id="createServiceModal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createServiceModalLabel">Create Service</h5>
                        <button type="button" @click="handleClose" >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Service Form -->
                        <form class="form-wrapper" @submit.prevent="createService">
                            <div class="input-wrapper">
                                <div class="mb-2">
                                    <label class="w-50" for="name">Name</label>
                                    <input type="text" class="shadow border border-red rounded py-2 px-3 mb-3" id="name" v-model="form.name">
                                    <div class="invalid-feedback" v-if="errors.name">{{ errors.name }}</div>
                                </div>

                                <div class="mb-2">
                                    <label class="w-50" for="timespan">Timespan</label>
                                    <input type="text" class="shadow border border-red rounded py-2 px-3 mb-3" id="timespan" v-model="form.timespan">
                                    <div class="invalid-feedback" v-if="errors.timespan">{{ errors.timespan }}</div>
                                </div>

                                <div class="mb-2">
                                    <label class="w-50" for="is_active">
                                        Active
                                    </label>
                                    <div class="checkbox-input">
                                        <input class="form-check-input py-2 px-2 mb-3" type="checkbox" id="is_active" v-model="form.is_active">
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label class="w-50" for="show_timespan">
                                        Show Timespan
                                    </label>
                                    <div class="checkbox-input">
                                        <input class="form-check-input" type="checkbox" id="show_timespan" v-model="form.show_timespan">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary my-4">Create</button>
                        </form>
                        <!-- End Service Form -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Create Service Modal -->
    </div>
</template>


<script>
import axios from 'axios';

export default {
    props: {
        showModal: Boolean,
    },
    data() {
        return {
            form: {
                name: '',
                timespan: '',
                is_active: false,
                show_timespan: false,
            },
            errors: {},
        };
    },
    methods: {
        createService() {
            axios.post('/api/services', {
                name: this.form.name,
                timespan: this.form.timespan,
                is_active: this.form.is_active,
                show_timespan: this.form.show_timespan,
            }).then(response => {
                this.$emit('service-created', response.data);

                this.form.name = '';
                this.form.timespan = '';
                this.form.is_active = false;
                this.form.show_timespan = false;

                this.errors = {}
            }).catch(error => {
                console.error(error);
            });
        },

        handleClose()
        {
            this.$emit('close');
        },

        validateForm() {

        }
    },
};
</script>
