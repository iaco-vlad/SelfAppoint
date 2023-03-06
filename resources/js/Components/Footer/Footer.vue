<template>
    <footer>
        <div class="container my-4">
            <div class="row">
                <div class="col-sm-6">
                    &copy; {{ currentYear }} by {{ owner }}. All rights reserved.
                </div>

                <div class="col-sm-6 text-right">
                    <a :href="technicalInformationLink" target="_blank">Technical information about the project</a>

                    <span> | </span>

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
            technicalInformationLink: 'https://iacovlad.notion.site/SelfAppoint-c3e54c3558bd428bbecfc1da3a6a5868',
            currentYear: new Date().getFullYear()
        };
    }
};
</script>

