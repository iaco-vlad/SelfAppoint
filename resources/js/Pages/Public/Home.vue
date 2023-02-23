<template>
    <div class="shadow-lg text-center">
        <h1 class="pt-5">Self-Appoint</h1>
        <h2 class="py-5"> Want to be responsible of your own appointments? </h2>
        <h3 class="py-5"> Create a new user, login, or use the sample user to start working with the app.</h3>

        <div class="py-5">
            <span class="small">or click here to make a quick appointment with</span>

            <router-link :to="{name: 'new-appointment', params: { administratorId: 1 }}">
                <button class="btn btn-outline-primary py-2 px-3 rounded mx-2 border-0" type="button">
                    Vlad
                </button>
            </router-link>
        </div>
    </div>
</template>

<script>
export default {}
</script>
