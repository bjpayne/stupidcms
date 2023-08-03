<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import {ref} from "vue";

defineProps({
    user: {
        type: Object,
    }
});

const page = usePage();
const user = page.props.user;
const avatarPreview = ref('data:image/jpeg;base64,' + page.props.user.avatar.avatar);

const form = useForm({
    _method: 'patch',
    first_name: user.first_name,
    last_name: user.last_name,
    email: user.email,
    avatar: user.avatar,
});

let previewAvatar = (event) => {
    let file = event.target.files[0];

    form.avatar = file;

    avatarPreview.value = URL.createObjectURL(file);
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="form.post(route('users.update'))" class="mt-6 space-y-6">
            <div class="flex gap-3 mb-3 max-w-5xl">
                <div class="w-1/3 flex items-center justify-center flex-col mr-6">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-64 h-auto fill-gray-300 cursor-pointer" v-if="! user.avatar" @click="$refs.avatar.click()">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z" clip-rule="evenodd" />
                    </svg>

                    <img id="avatar-preview" :src="avatarPreview"
                         alt="User Avatar" @click="$refs.avatar.click()"
                         class="w-64 h-auto fill-gray-300 rounded-full cursor-pointer" v-if="user.avatar"
                    />

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="avatar">Upload file</label>
                        <input class="block w-full text-gray-900 focus:outline-none"
                               id="avatar" type="file" ref="avatar" accept="image/jpeg"
                               @input="previewAvatar($event)"
                        >
                    </div>
                </div>
                <div class="w-2/3">
                    <div>
                        <InputLabel for="first-name" value="First name" />

                        <TextInput
                            id="first-name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.first_name"
                            required
                            autofocus
                            autocomplete="first-name"
                        />

                        <InputError class="mt-2" :message="form.errors.first_name" />
                    </div>

                    <div>
                        <InputLabel for="last-name" value="Last name" />

                        <TextInput
                            id="last-name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.last_name"
                            required
                            autofocus
                            autocomplete="last-name"
                        />

                        <InputError class="mt-2" :message="form.errors.last_name" />
                    </div>

                    <div>
                        <InputLabel for="email" value="Email" />

                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autocomplete="username"
                        />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing" :class="{ 'opacity-50' : form.processing }">Save</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
