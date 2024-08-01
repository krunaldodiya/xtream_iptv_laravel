<script setup lang="ts">
import { defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps<{
    data: string;
}>();

const form = useForm({
    message: "",
});

const submit = (e: Event) => {
    form.post(route("chatai.store"), {
        onSuccess: (page) => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Chatai Home" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Chatai Home</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-10">
                <div class="text-white">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label for="message" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                                Write a message
                            </label>

                            <textarea
                                id="message"
                                name="message"
                                placeholder="Write a message"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 p-2 text-gray-600"
                                :class="form.errors.message ? 'border-red-500' : ''"
                                v-model="form.message"
                                rows="10"
                            ></textarea>

                            <p v-if="form.errors.message" class="text-red-500 text-sm mt-2">{{ form.errors.message }}</p>
                        </div>

                        <button
                            type="submit"
                            class="w-96 mt-2 px-4 py-2 bg-red-500 font-bold text-white rounded-md shadow-sm outline-none hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500"
                            :disabled="form.processing"
                        >
                            {{ form.processing ? "Loading..." : "Send Message" }}
                        </button>
                    </form>

                    <!-- Display the data if it exists -->
                    <div v-if="props.data" class="mt-6 p-4 bg-gray-800 rounded-md">
                        <h3 class="text-lg font-semibold text-gray-300">Generated Data</h3>
                        <p class="text-gray-400">{{ props.data }}</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
