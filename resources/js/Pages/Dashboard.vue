<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3'
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "../../../vendor/laravel/breeze/stubs/inertia-vue-ts/resources/js/Components/SecondaryButton.vue";
import DeleteButton from "../../../vendor/laravel/breeze/stubs/inertia-vue-ts/resources/js/Components/DeleteButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Modal from "@/Components/Modal.vue";
import {nextTick, ref} from "vue";
import PageTitle from "@/Components/PageTitle.vue";

defineProps({

});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <PageTitle>Dashboard</PageTitle>
    </AuthenticatedLayout>
</template>
