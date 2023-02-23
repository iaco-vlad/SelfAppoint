<template>
    <footer>
        <div class="container my-4">
            <div class="row">
                <div class="col-sm-6">
                    &copy; {{ currentYear }} by {{ owner }}. All rights reserved.
                </div>
                <div class="col-sm-6 text-right">
                    <a :href="ownerLink" target="_blank">{{ owner }}</a>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    name: 'AppFooter',
    data() {
        return {
            owner: 'Vlad Iacovenco',
            ownerLink: 'https://www.vlad-iacovenco.com',
            currentYear: new Date().getFullYear()
        };
    }
};
</script>

