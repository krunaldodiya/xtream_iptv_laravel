<script setup lang="ts">
import GithubAccountsList from "@/Components/Github/Accounts/List.vue";
import { GithubAccountInterface } from "@/Interfaces/main";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import { Head, Link } from "@inertiajs/vue3";
import Button from "primevue/button";

const props = defineProps({
    github_accounts: {
        type: Array<GithubAccountInterface>,
        required: true,
    },
});
</script>

<template>
    <Head title="Github Accounts" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Github Accounts
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="shadow-sm sm:rounded-lg">
                    <div class="card flex justify-content-center">
                        <Link :href="route('github-accounts.code')">
                            <Button label="Add Github Account" />
                        </Link>
                    </div>
                </div>

                <div class="mt-8">
                    <GithubAccountsList :github_accounts="github_accounts" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
