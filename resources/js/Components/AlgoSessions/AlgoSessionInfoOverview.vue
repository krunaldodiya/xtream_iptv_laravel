<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    algo_session_id: {
        type: Number,
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link
        class="text-sm"
        :class="{
            'text-black': title == 'Overview',
            'text-blue-400': title != 'Overview',
        }"
        :href="route('algo-sessions.overview', { id: algo_session_id })"
    >
        Overview
    </Link>

    <span class="mx-1 text-sm text-gray-400">|</span>

    <Link
        class="text-sm"
        :class="{
            'text-black': title == 'Orders',
            'text-blue-400': title != 'Orders',
        }"
        :href="route('algo-sessions.orders', { id: algo_session_id })"
    >
        Orders
    </Link>

    <span class="mx-1 text-sm text-gray-400">|</span>

    <Link
        class="text-sm"
        :class="{
            'text-black': title == 'Positions',
            'text-blue-400': title != 'Positions',
        }"
        :href="route('algo-sessions.positions', { id: algo_session_id })"
    >
        Positions
    </Link>
</template>