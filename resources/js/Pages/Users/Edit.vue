<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateUserForm from './Partials/UpdateUserForm.vue';
import { Head } from '@inertiajs/vue3';
import PageTitle from "@/Components/PageTitle.vue";

defineProps({
    user: {
        type: Object,
    }
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <PageTitle>Profile</PageTitle>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mb-5">
            <UpdateUserForm
                class="max-w-2xl"
            />
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mb-5">
            <UpdatePasswordForm class="max-w-xl" />
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mb-5">
            <DeleteUserForm class="max-w-xl" />
        </div>
    </AuthenticatedLayout>
</template>
