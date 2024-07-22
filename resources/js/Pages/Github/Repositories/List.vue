<script setup lang="ts">
import GithubRepositoriesList from "@/Components/Github/Repositories/List.vue";
import {
    GithubAccountInterface,
    GithubRepositoryInterface,
} from "@/Interfaces/main";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Sidebar from "primevue/sidebar";

import { Head, useForm } from "@inertiajs/vue3";
import Button from "primevue/button";
import { ref } from "vue";
import InputText from "primevue/inputtext";
import Dropdown from "primevue/dropdown";

const props = defineProps({
    github_accounts: {
        type: Array<GithubAccountInterface>,
        required: true,
    },
    github_repositories: {
        type: Array<GithubRepositoryInterface>,
        required: true,
    },
});

const visible = ref(false);

const form = useForm({
    github_account_id: "",
    repository_name: "",
});

const add_github_repository = (e: Event) => {
    form.post(route("github-repositories.store"), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            form.reset();
            visible.value = false;
        },
    });
};
</script>

<template>
    <Head title="Github Repositories" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Github Repositories
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="shadow-sm sm:rounded-lg">
                    <div class="card flex justify-content-center">
                        <Sidebar
                            v-model:visible="visible"
                            header="Add Github Repository"
                        >
                            <form
                                @submit.prevent="add_github_repository"
                                class="space-y-2"
                            >
                                <div>
                                    <Dropdown
                                        v-model="form.github_account_id"
                                        :options="github_accounts"
                                        optionLabel="username"
                                        optionValue="account_id"
                                        placeholder="Select a github account"
                                        class="w-full"
                                        :invalid="
                                            form.errors.github_account_id
                                                ? true
                                                : false
                                        "
                                    />

                                    <small
                                        class="text-red-500"
                                        id="username-help"
                                        v-if="form.errors.github_account_id"
                                        v-text="form.errors.github_account_id"
                                    />
                                </div>

                                <div>
                                    <InputText
                                        class="w-full"
                                        :invalid="
                                            form.errors.repository_name
                                                ? true
                                                : false
                                        "
                                        type="text"
                                        v-model="form.repository_name"
                                        placeholder="Repository name"
                                    />

                                    <small
                                        class="text-red-500"
                                        id="username-help"
                                        v-if="form.errors.repository_name"
                                        v-text="form.errors.repository_name"
                                    />
                                </div>

                                <div>
                                    <Button
                                        class="w-full mt-5"
                                        type="submit"
                                        label="Add Github Repository"
                                    />
                                </div>
                            </form>
                        </Sidebar>

                        <Button
                            label="Add Github Repository"
                            @click="visible = true"
                        />
                    </div>
                </div>

                <div class="mt-8">
                    <GithubRepositoriesList
                        :github_repositories="github_repositories"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
