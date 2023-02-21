<template>
    <div class="text-center">
        <h1 class="py-5 mr-auto"> Events </h1>

        <div>
            <button type="button" class="btn btn-primary mb-3" @click="showWindowModal">
                Create a window for yourself
            </button>
        </div>

        <table class="table" v-if="events.length">
            <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Description</th>
                <th>User Name</th>
                <th>Service Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="event in events" :key="event.id">
                <td>{{ event.date }}</td>
                <td>{{ event.time }}</td>
                <td>{{ event.status }}</td>
                <td>{{ event.description }}</td>
                <td>{{ event.user_name }}</td>
                <td>{{ event.service_name }}</td>
                <td>
                    <button
                        v-for="action in getEventActions(event)"
                        type="button"
                        class="btn"
                        :class="{'btn-danger': !action.isSuccessButton, 'btn-success': action.isSuccessButton}"
                        @click="updateEventStatus(event.id, action.status)"
                    >
                        {{ action.name }}
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <WindowModal
            :show-modal="windowModalActive"
            @close="windowModalActive = false"
            @window-created="fetchEvents"
        />
    </div>
</template>

<script>
import {CANCELED, CONFIRMED, DECLINED, HONORED, PENDING, UNHONORED} from "@/Utils/Enums/EventStatusEnum";
import WindowModal from "@/Pages/Private/User/Events/WindowModal.vue";

export default {
    components: {WindowModal},
    data() {
        return {
            events: [],
            windowModalActive: false,
        };
    },
    mounted() {
        this.fetchEvents();
    },
    methods: {
        fetchEvents() {
            axios.get('/api/events')
                .then(response => {
                    // Handle the response from the server
                    this.events = response.data.events;
                })
                .catch(error => {
                    console.error(error);
                });
            this.windowModalActive = false;
        },
        showWindowModal() {
            this.windowModalActive = true;
        },
        updateEventStatus(eventId, status) {
            this.submitEventStatus(eventId, status);
        },
        submitEventStatus(eventId, status) {
            axios.patch(`/api/events/${eventId}/update-status`, {
                status: status,
            })
                .then(() => {
                    this.fetchEvents();
                })
                .catch(() => {
                    // Handle any errors that occur during the request
                });
        },
        getEventActions(event) {
            if (
                this.loggedUserId === event.administrator_id
                && (event.status === CONFIRMED || event.status === PENDING)
            ) {
                return this.getActionButtonsByEvent(event);
            }
            if (
                this.loggedUserId === event.user_id
                && event.status === PENDING
            ) {
                return this.getActionButtonsByEvent(event, false);
            }
            return [];
        },
        getActionButtonsByEvent(event, isAdministrator = true) {
            let eventDate = new Date(event.date);
            let eventDateTime = eventDate.toISOString().slice(0, 10) + ' ' + event.time;
            const isEventInThePast = new Date(eventDateTime) < new Date();

            switch (event.status) {
                case PENDING:
                    if (!isEventInThePast) {
                        if (isAdministrator) {
                            return [
                                {
                                    name: 'Confirm',
                                    status: CONFIRMED,
                                    isSuccessButton: true,
                                },
                                {
                                    name: 'Decline',
                                    status: DECLINED,
                                    isSuccessButton: false,
                                },
                            ];
                        }
                        return [
                            {
                                name: 'Cancel',
                                status: CANCELED,
                                isSuccessButton: false,
                            },
                        ];
                    }
                    return '';
                case CONFIRMED:
                    if (isAdministrator && isEventInThePast) {
                        return [
                            {
                                name: 'Honored',
                                status: HONORED,
                                isSuccessButton: true,
                            },
                            {
                                name: 'Unhonored',
                                status: UNHONORED,
                                isSuccessButton: false,
                            },
                        ];
                    }
                    break;
                default:
                    throw new Error('Status not mapped.');
            }
        }
    },
    computed: {
        loggedUserId() {
            return this.$store.state.user.id;
        },
    }
}
</script>
