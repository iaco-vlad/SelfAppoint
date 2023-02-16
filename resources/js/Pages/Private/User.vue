<template>
    <div class="container shadow-lg py-5">
        <div class="row">
            <div class="col-md-4">
                <!-- List of links -->
                <ul class="list-group text-center w-50 mx-auto">
                    <li class="list-group-item"><router-link to="/profile">Profile</router-link></li>
                    <li class="list-group-item"><router-link to="/events">Events</router-link></li>
                    <li class="list-group-item"><router-link to="/services">Services</router-link></li>
                </ul>
            </div>
            <div class="col-md-8">
                <router-view/>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'User',

    data() {
        return {
            pages: [
                {title: 'Profile', name: 'user.profile'},
                {title: 'Events', name: 'user.events'},
                {title: 'Services', name: 'user.services'},
            ],
            tableData: [
                { col1: 'Row 1, Column 1', col2: 'Row 1, Column 2', col3: 'Row 1, Column 3' },
                { col1: 'Row 2, Column 1', col2: 'Row 2, Column 2', col3: 'Row 2, Column 3' },
                { col1: 'Row 3, Column 1', col2: 'Row 3, Column 2', col3: 'Row 3, Column 3' },
            ]
        };
    }
};
</script>
