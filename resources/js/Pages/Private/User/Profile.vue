<template>
    <div class="text-center">
        <h1 class="py-5 mr-auto"> Profile </h1>

        <form class="form-wrapper">
            <div class="input-wrapper">
                <div class="mb-4">
                    <label class="w-50" for="name">Name</label>
                    <input type="text" class="shadow border rounded py-2 px-4" id="name" v-model="name">
                </div>
                <div class="mb-4">
                    <label class="w-50" for="title">Title</label>
                    <input type="text" class="shadow border rounded py-2 px-4" id="title" v-model="title">
                </div>
                <div class="mb-4">
                    <label class="w-50" for="password">New password</label>
                    <input type="password" class="shadow border rounded py-2 px-4" id="password" v-model="password">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Save</button>
        </form>
    </div>
</template>

<script>
// TODO: Update profile with axios
</script>
