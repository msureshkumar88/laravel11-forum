<template>
    <AppLayout>
        <container>
            <ul class="divide-y">
                <li v-for="post in posts.data" :key="post.id" class="flex flex-col items-baseline justify-between md:flex-row">
                    <Link :href="post.routes.show" class="block group px-2 py-4">
                        <span class="font-bold text-lg group-hover:text-indigo-500">{{ post.title }}</span>
                        <span class="first-letter:uppercase block pt-1 text-sm text-gray-600">{{ formattedDate(post) }} ago by {{ post.user.name }}</span>
                    </Link>
                    <Link
                        href="/"
                        class="mb-2 rounded-full border border-pink-500 px-2 py-0.5 text-pink-500 hover:bg-indigo-500 hover:text-indigo-50"
                    >
                        {{ post.topic.name }}
                    </Link>
                </li>
            </ul>
            <Pagination :meta="posts.meta" :only="['posts']" class="mt-2"/>
        </container>
    </AppLayout>
</template>


<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import Pagination from "@/Components/Pagination.vue";
import {Link} from "@inertiajs/vue3";
import {formatDistance, parseISO} from "date-fns";
import {relativeDate} from "@/Utilities/date.js";
defineProps(['posts']);


const formattedDate = (post) => relativeDate(post.created_at);
</script>
