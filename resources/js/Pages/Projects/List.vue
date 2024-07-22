<script setup lang="ts">
import { ProjectInterface } from "@/Interfaces/main";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import { Head, Link, router } from "@inertiajs/vue3";
import Button from "primevue/button";
import Column from "primevue/column";
import DataTable from "primevue/datatable";

const props = defineProps({
    projects: {
        type: Array<ProjectInterface>,
        required: true,
    },
});
</script>

<template>
    <Head title="Brokers" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Projects
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="shadow-sm sm:rounded-lg">
                    <div class="card flex justify-content-center">
                        <Link :href="route('projects.create')">
                            <Button label="Create Project" />
                        </Link>
                    </div>
                </div>

                <div class="mt-8">
                    <DataTable :value="projects" tableStyle="min-width: 50rem">
                        <template #empty>
                            <div class="text-gray-400">
                                No records found
                            </div></template
                        >

                        <Column field="title" header="Title"></Column>

                        <Column header="Status">
                            <template #body="{ data }">
                                <span
                                    :class="{
                                        'text-green-500':
                                            data.status == 'Active',
                                        'text-red-500':
                                            data.status == 'Inactive',
                                    }"
                                    >{{ data.status }}</span
                                >
                            </template>
                        </Column>

                        <Column header="Broker">
                            <template #body="{ data }">
                                <span>{{
                                    data.broker.broker_name
                                }}</span></template
                            >
                        </Column>

                        <Column header="Github Repository">
                            <template #body="{ data }">
                                <span>{{
                                    data.github_repository.repository_full_name
                                }}</span></template
                            >
                        </Column>

                        <Column header="Action" class="space-x-2">
                            <template #body="{ data }">
                                <Link
                                    :href="
                                        route('projects.detail', {
                                            project_id: data.id,
                                        })
                                    "
                                >
                                    <Button
                                        icon="pi pi-eye"
                                        outlined
                                        rounded
                                        severity="success"
                                        class="w-8 h-8"
                                    />
                                </Link>

                                <Link
                                    :href="
                                        route('projects.edit', {
                                            project_id: data.id,
                                        })
                                    "
                                >
                                    <Button
                                        icon="pi pi-pencil"
                                        outlined
                                        rounded
                                        severity="info"
                                        class="w-8 h-8"
                                    />
                                </Link>
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
