<script setup lang="ts">
import { Head, useForm } from "@inertiajs/vue3";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ProjectInterface } from "@/Interfaces/main";
import { PropType, ref } from "vue";
import Button from "primevue/button";
import ProjectOverview from "@/Components/Projects/ProjectOverview.vue";
import ProjectAlgoSessions from "@/Components/Projects/ProjectAlgoSessions.vue";

const props = defineProps({
    project: {
        type: Object as PropType<ProjectInterface>,
        required: true,
    },
});

const form = useForm({
    broker_id: "",
    data_broker_id: "",
    github_repository_id: "",
    title: "",
    description: "",
});

const submit = (e: Event) => {
    form.post(route("projects.store"), {
        preserveScroll: true,
        preserveState: true,
    });
};

const selected_tab = ref("Overview");
</script>

<template>
    <Head title="Project Detail" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Project Detail
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex space-x-2 mb-10">
                    <Button
                        :disabled="selected_tab == 'Overview'"
                        :severity="
                            selected_tab == 'Overview' ? 'secondary' : 'info'
                        "
                        @click="selected_tab = 'Overview'"
                        class="text-sm uppercase"
                    >
                        Overview
                    </Button>

                    <Button
                        :disabled="selected_tab == 'AlgoSessions'"
                        :severity="
                            selected_tab == 'AlgoSessions'
                                ? 'secondary'
                                : 'info'
                        "
                        @click="selected_tab = 'AlgoSessions'"
                        class="text-sm uppercase"
                    >
                        Algo Sessions
                    </Button>
                </div>

                <div class="mt-5">
                    <ProjectOverview
                        :project="project"
                        v-if="selected_tab == 'Overview'"
                    />

                    <ProjectAlgoSessions
                        :project="project"
                        v-if="selected_tab == 'AlgoSessions'"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
