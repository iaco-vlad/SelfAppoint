<template>
    <div class="container-fluid">
        <div class="row">
            <!-- First column: List -->
            <div class="col-md-4">
                <ul class="list-group">
                    <router-link v-for="(page, index) in pages" :key="index" :to="{name: page.name}" class="list-group-item">{{ page.title }}</router-link>
                </ul>
            </div>
            <!-- Second column: Table -->
            <div class="col-md-8">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Header 1</th>
                        <th>Header 2</th>
                        <th>Header 3</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(row, index) in tableData" :key="index">
                        <td>{{ row.col1 }}</td>
                        <td>{{ row.col2 }}</td>
                        <td>{{ row.col3 }}</td>
                    </tr>
                    </tbody>
                </table>
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
