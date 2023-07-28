<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <header class="w-100 flex flex-end">
                <div id="avatar"></div>
            </header>
            <div class="flex">
                <!-- Left Sidebar -->
                <nav class="w-1/5">
                    <!-- Page Heading -->
                    <div v-if="$slots.header">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            <slot name="header" />
                        </div>
                    </div>
                </nav>

                <!-- Page Content -->
                <main class="w-4/5">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
