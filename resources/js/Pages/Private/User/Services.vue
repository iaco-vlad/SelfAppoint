<template>
    <div class="text-center">
        <h1 class="py-5 mr-auto"> Services </h1>

        <div>
            <button type="button" class="btn btn-primary mb-3" @click="showCreateModal">Create new service</button>
        </div>

        <table class="table" v-if="services.length">
            <thead>
            <tr>
                <th>Name</th>
                <th>Timespan</th>
                <th>Active</th>
                <th>Show Timespan</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(service, index) in services" :key="service.id">
                <td>{{ service.name }}</td>
                <td>{{ service.timespan }}</td>
                <td :class="{'text-success': service.is_active, 'text-danger': !service.is_active}">{{ service.is_active ? 'Yes' : 'No' }}</td>
                <td>{{ service.show_timespan ? 'Yes' : 'No' }}</td>
                <td>
                    <button type="button" class="btn btn-primary" @click="showUpdateModal(index)">Update</button>
                    <button type="button" class="btn btn-danger" @click="confirmDelete(service.id)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>

        <p class="py-4" v-else>There are no services for your user yet.</p>

        <CreateModal
            :show-modal="createModalActive"
            @close="createModalActive = false"
            @service-created="fetchServices"
        />
        <UpdateModal
            :show-modal="updateModalActive"
            :service="selectedService"
            @close="updateModalActive = false"
            @service-updated="fetchServices"
        />
    </div>
</template>

<script>
import sampleServices from './ServicesData';
import CreateModal from './Services/CreateServiceModal.vue'
import UpdateModal from './Services/UpdateServiceModal.vue'

export default {
    components: {
        CreateModal,
        UpdateModal
    },

    data() {
        return {
            services: sampleServices, // array of objects with the properties name, timespan, is_active, and show_timespan
            selectedService: {},
            createModalActive: false,
            updateModalActive: false,
        };
    },
    mounted() {
        this.fetchServices();
    },
    methods: {
        fetchServices() {
            axios.get('/api/services')
                .then(response => {
                    this.services = response.data.services;
                })
                .catch(error => {
                    console.error(error);
                });
            this.createModalActive = false;
            this.updateModalActive = false;
        },
        showCreateModal() {
            this.createModalActive = true;
        },
        showUpdateModal(index) {
            this.selectedService = { ...this.services[index] };
            this.updateModalActive = true;
        },
        confirmDelete(id) {
            if (confirm('Are you sure you want to delete this service?')) {
                axios.delete('/api/services/' + id)
                    .then(() => {
                        this.fetchServices();
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        },
    },
};
</script>
