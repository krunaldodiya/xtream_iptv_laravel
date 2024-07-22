<script setup lang="ts">
import SharedLayout from "@/Layouts/SharedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Home" />

    <SharedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Welcome to Xteam IPTV
            </h2>
        </template>

        <div class="py-12">
            <div class="text-white">
                Welcome to Xteam IPTV
            </div>
        </div>
    </SharedLayout>
</template>
