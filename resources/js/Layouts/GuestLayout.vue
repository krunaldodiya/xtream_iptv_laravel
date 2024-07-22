<script setup lang="ts">
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { useThemeStore } from "@/Stores/theme";
import { Link } from "@inertiajs/vue3";

const themeStore = useThemeStore();
</script>

<template>
    <div :class="{ dark: themeStore.is_dark }">
        <div
            class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900"
        >
            <div class="flex justify-between h-16">
                <div class="sm:fixed sm:top-0 sm:left-0 p-6 text-left">
                    <Link href="/">
                        <ApplicationLogo
                            class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"
                        />
                    </Link>
                </div>

                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                    <Link
                        :href="route('login')"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >
                        Log in
                    </Link>

                    <Link
                        :href="route('register')"
                        class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >
                        Register
                    </Link>
                </div>
            </div>

            <div
                class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg"
            >
                <slot />
            </div>
        </div>
    </div>
</template>
