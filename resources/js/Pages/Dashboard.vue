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

defineProps({
    users: Array
});

const confirmingUserDeletion = ref(false);
const userPasswordInput = ref(null);

let form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

let userForm = useForm({
    password: '',
    user_id: ''
});

let submit = () => {
    form.post(route('users.store'), {
        onFinish: () => form.reset(),
    });
};

let confirmUserDeletion = (user_id) => {
    confirmingUserDeletion.value = true;

    nextTick(() => userPasswordInput.value.focus());

    userForm.user_id = user_id;
};

let deleteUser = () => {
    userForm.delete(route('profile.user_profile'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => userPasswordInput.value.focus(),
        onFinish: () => userForm.reset(),
    });
};

let closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div class="flex gap-3 mb-3">
                                <div class="w-1/4">
                                    <InputLabel for="first-name" value="First name"/>

                                    <TextInput
                                        id="first-name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.first_name"
                                        required
                                    />

                                    <InputError class="mt-2" :message="form.errors.first_name"/>
                                </div>

                                <div class="w-1/4">
                                    <InputLabel for="first-name" value="Last name"/>

                                    <TextInput
                                        id="last-name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.last_name"
                                        required
                                    />

                                    <InputError class="mt-2" :message="form.errors.last_name"/>
                                </div>

                                <div class="w-1/4">
                                    <InputLabel for="email" value="Email"/>

                                    <TextInput
                                        id="email"
                                        type="email"
                                        class="mt-1 block w-full"
                                        v-model="form.email"
                                        required
                                    />

                                    <InputError class="mt-2" :message="form.errors.email"/>
                                </div>

                                <div class="w-1/4 flex gap-3">
                                    <div class="w-1/2">
                                        <InputLabel for="password" value="Password"/>

                                        <TextInput
                                            id="password"
                                            type="password"
                                            class="mt-1 block w-full"
                                            v-model="form.password"
                                            required
                                        />

                                        <InputError class="mt-2" :message="form.errors.password"/>
                                    </div>

                                    <div class="w-1/2">
                                        <InputLabel for="password-confirmation" value="Confirm"/>

                                        <TextInput
                                            id="password-confirmation"
                                            type="password"
                                            class="mt-1 block w-full"
                                            v-model="form.password_confirmation"
                                            required
                                        />

                                        <InputError class="mt-2" :message="form.errors.password_confirmation"/>

                                    </div>
                                </div>
                            </div>
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Submit
                            </PrimaryButton>
                        </form>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <table class="w-full text-sm text-left text-gray-800">
                        <thead class="text-xs uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">First Name</th>
                                <th scope="col" class="px-6 py-3">Last Name</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(user, index) in users" class="border-b"
                                :class="{'bg-gray-50 text-gray-800': index & 1}"
                            >
                                <td class="px-6 py-3">{{ user.first_name }}</td>
                                <td class="px-6 py-3">{{ user.last_name }}</td>
                                <td class="px-6 py-3">{{ user.email }}</td>
                                <td class="px-6 py-3 text-right">
                                    <SecondaryButton class="mr-3">
                                        Edit
                                    </SecondaryButton>

                                    <DeleteButton @click="confirmUserDeletion(user.id)">
                                        Delete
                                    </DeleteButton>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete this account?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once this account is deleted, all of its resources and data will be permanently deleted. Please
                    enter the account password to confirm you would like to permanently delete this account.
                </p>

                <div class="mt-6">
                    <InputLabel for="password" value="Password" class="sr-only" />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="userForm.password"
                        type="password"
                        class="mt-1 block w-full"
                        placeholder="Password"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="userForm.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">Cancel</SecondaryButton>

                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': userForm.processing }"
                        :disabled="userForm.processing"
                        @click="deleteUser"
                    >
                        Delete Account
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
