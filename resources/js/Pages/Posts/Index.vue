<template>
    <AppLayout>
        <container>
            <ul class="divide-y">
                <li v-for="post in posts" class="px-2 py-4">
                    <span class="font-bold text-lg">{{post.title}}</span>
                </li>
            </ul>
        </container>
    </AppLayout>
</template>


<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/container.vue";
defineProps(['posts']);
</script>
