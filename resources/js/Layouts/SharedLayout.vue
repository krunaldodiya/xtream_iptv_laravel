<script setup lang="ts">
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { useThemeStore } from "@/Stores/theme";
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const themeStore = useThemeStore();
const page = usePage();

const is_logged_in = computed(() => {
    return page.props.auth.user !== null;
});
</script>

<template>
    <div :class="{ dark: themeStore.is_dark }">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <div class="flex justify-between h-16">
                <div class="sm:fixed sm:top-0 sm:left-0 p-6 text-left">
                    <Link href="/">
                        <ApplicationLogo
                            class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"
                        />
                    </Link>
                </div>

                <div
                    class="sm:fixed sm:top-0 sm:right-0 p-6 text-right"
                    v-if="is_logged_in"
                >
                    <Link
                        :href="route('dashboard')"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >
                        Dashboard
                    </Link>
                </div>

                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right" v-else>
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

            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
