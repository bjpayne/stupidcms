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
    users: Array,
});

const confirmingUserDeletion = ref(false);
const editingUser = ref(false);
const userPasswordInput = ref(null);
const avatarPreview = ref('#');

let form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation: '',
    avatar: ''
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

let editUser = (user_id) => {
    editingUser.value = true;
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

let previewAvatar = (event) => {
    let file = event.target.files[0];

    form.avatar = file;

    avatarPreview.value = URL.createObjectURL(file);
};
</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <PageTitle>Users</PageTitle>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mb-5">
            <header>
                <h2 class="text-lg font-medium text-gray-900">Add User</h2>

                <p class="mt-1 text-sm text-gray-600">
                    Add a new user to the system.
                </p>
            </header>
            <form @submit.prevent="submit">
                <div class="flex gap-3 mb-3 max-w-4xl">
                    <div class="w-1/3 flex items-center justify-center flex-col mr-6">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-64 h-auto fill-gray-300 cursor-pointer" v-if="! form.avatar" @click="$refs.avatar.click()">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z" clip-rule="evenodd" />
                        </svg>

                        <img id="avatar-preview" :src="avatarPreview" alt="User Avatar" @click="$refs.avatar.click()"
                             class="w-64 h-auto fill-gray-300 rounded-full cursor-pointer" v-if="form.avatar"
                        />

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900" for="avatar">Upload file</label>
                            <input class="block w-full text-gray-900 focus:outline-none"
                                   id="avatar" type="file" ref="avatar"
                                   @input="previewAvatar($event)"
                            >
                        </div>
                    </div>
                    <div class="w-2/3">
                        <div class="mb-2">
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

                        <div class="mb-2">
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

                        <div class="mb-2">
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

                        <div class="mb-2">
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

                        <div class="mb-2">
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

        <div class="bg-white shadow sm:rounded-lg mb-5">
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
