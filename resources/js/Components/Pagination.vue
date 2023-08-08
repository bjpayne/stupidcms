<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    users: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <nav aria-label="Pagination" class="flex items-center justify-center" v-if="users.links.length > 1">
        <Link class="flex items-center justify-center px-3 h-8 ml-0 leading-tight rounded-l-lg text-white bg-gray-800 border border-gray-700 hover:text-brand-green"
              :href="users.first_page_url" v-if="users.current_page !== 1"

        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                <path fill-rule="evenodd" d="M15.79 14.77a.75.75 0 01-1.06.02l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 111.04 1.08L11.832 10l3.938 3.71a.75.75 0 01.02 1.06zm-6 0a.75.75 0 01-1.06.02l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 111.04 1.08L5.832 10l3.938 3.71a.75.75 0 01.02 1.06z" clip-rule="evenodd" />
            </svg>
        </Link>
        <div class="flex items-center justify-center px-3 h-8 ml-0 leading-tight rounded-l-lg text-gray-500 bg-gray-800 border border-gray-700"
             v-else
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                <path fill-rule="evenodd" d="M15.79 14.77a.75.75 0 01-1.06.02l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 111.04 1.08L11.832 10l3.938 3.71a.75.75 0 01.02 1.06zm-6 0a.75.75 0 01-1.06.02l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 111.04 1.08L5.832 10l3.938 3.71a.75.75 0 01.02 1.06z" clip-rule="evenodd" />
            </svg>
        </div>
        <Link class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-white bg-gray-800 border border-gray-700 hover:text-brand-green"
              :href="users.prev_page_url" v-if="users.prev_page_url !== null"

        >
            Prev
        </Link>
        <div class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-gray-800 border border-gray-700"
              v-else
        >
            Prev
        </div>
        <div class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-brand-green bg-gray-800 border border-gray-700">
            {{ users.current_page }}
        </div>
        <Link class="flex items-center justify-center px-3 h-8 leading-tight text-white bg-gray-800 border border-gray-700 hover:text-brand-green"
              :href="users.next_page_url" v-if="users.next_page_url !== null"
        >
            Next
        </Link>
        <div class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-800 border border-gray-700"
              :href="users.next_page_url" v-else
        >
            Next
        </div>
        <Link class="flex items-center justify-center px-3 h-8 ml-0 leading-tight rounded-r-lg text-white bg-gray-800 border border-gray-700 hover:text-brand-green"
              :href="users.last_page_url" v-if="users.last_page !== users.current_page"

        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                <path fill-rule="evenodd" d="M10.21 14.77a.75.75 0 01.02-1.06L14.168 10 10.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M4.21 14.77a.75.75 0 01.02-1.06L8.168 10 4.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
            </svg>
        </Link>
        <div class="flex items-center justify-center px-3 h-8 ml-0 leading-tight rounded-r-lg text-gray-500 bg-gray-800 border border-gray-700" v-else>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                <path fill-rule="evenodd" d="M10.21 14.77a.75.75 0 01.02-1.06L14.168 10 10.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M4.21 14.77a.75.75 0 01.02-1.06L8.168 10 4.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
            </svg>
        </div>
    </nav>
</template>
