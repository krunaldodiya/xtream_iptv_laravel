<script setup lang="ts">
import { PropType } from "vue";

import { Head, useForm } from "@inertiajs/vue3";

import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
    BrokerInterface,
    GithubRepositoryInterface,
    ProjectInterface,
} from "@/Interfaces/main";
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import Textarea from "primevue/textarea";

const props = defineProps({
    project: {
        type: Object as PropType<ProjectInterface>,
        required: true,
    },

    brokers: {
        type: Array<BrokerInterface>,
        required: true,
    },

    data_brokers: {
        type: Array<BrokerInterface>,
        required: true,
    },

    github_repositories: {
        type: Array<GithubRepositoryInterface>,
        required: true,
    },
});

const form = useForm({
    broker_id: props.project.broker_id,
    data_broker_id: props.project.data_broker_id,
    github_repository_id: props.project.github_repository_id,
    title: props.project.title,
    description: props.project.description,
});

const submit = (e: Event) => {
    form.post(route("projects.update", { project_id: props.project.id }), {
        preserveScroll: true,
        preserveState: true,
    });
};
</script>

<template>
    <Head title="Update Project" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Update Project
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="submit">
                    <div class="mb-5">
                        <InputLabel htmlFor="broker_id" value="Broker" />

                        <Dropdown
                            v-model="form.broker_id"
                            :options="brokers"
                            optionLabel="broker_name"
                            optionValue="id"
                            placeholder="Select a broker"
                            class="w-96"
                            :invalid="form.errors.broker_id ? true : false"
                            disabled
                        />

                        <InputError
                            :message="form.errors.broker_id"
                            class="mt-2"
                        />
                    </div>

                    <div class="mb-5">
                        <InputLabel
                            htmlFor="data_broker_id"
                            value="Data Broker"
                        />

                        <Dropdown
                            v-model="form.data_broker_id"
                            :options="data_brokers"
                            optionLabel="broker_name"
                            optionValue="id"
                            placeholder="Select a data broker"
                            class="w-96"
                            :invalid="form.errors.data_broker_id ? true : false"
                            disabled
                        />

                        <InputError
                            :message="form.errors.data_broker_id"
                            class="mt-2"
                        />
                    </div>

                    <div class="mb-5">
                        <InputLabel
                            htmlFor="github_repository_id"
                            value="Github Repository"
                        />

                        <Dropdown
                            v-model="form.github_repository_id"
                            :options="github_repositories"
                            optionLabel="repository_full_name"
                            optionValue="id"
                            placeholder="Select a github repository"
                            class="w-96"
                            :invalid="
                                form.errors.github_repository_id ? true : false
                            "
                            disabled
                        />

                        <InputError
                            :message="form.errors.github_repository_id"
                            class="mt-2"
                        />
                    </div>

                    <div class="mb-5">
                        <InputLabel htmlFor="title" value="Title" />

                        <TextInput
                            type="text"
                            id="title"
                            name="title"
                            placeholder="Title"
                            class="w-96 border-gray-300 rounded-md shadow-sm"
                            :class="form.errors.title && 'border-red-500'"
                            isFocused="true"
                            v-model="form.title"
                        />

                        <InputError :message="form.errors.title" class="mt-2" />
                    </div>

                    <div class="mb-5">
                        <InputLabel htmlFor="description" value="Description" />

                        <Textarea
                            type="text"
                            id="description"
                            name="description"
                            placeholder="Description"
                            class="w-96 border-gray-300 rounded-md shadow-sm"
                            :class="form.errors.description && 'border-red-500'"
                            isFocused="true"
                            v-model="form.description"
                            autoResize
                            rows="5"
                            cols="30"
                        />

                        <InputError
                            :message="form.errors.description"
                            class="mt-2"
                        />
                    </div>

                    <Button
                        class="mt-5 w-96 border-gray-300 rounded-md shadow-sm"
                        type="submit"
                        :disabled="form.processing"
                    >
                        {{
                            form.processing ? "Loading..." : "Update Project"
                        }}</Button
                    >
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
