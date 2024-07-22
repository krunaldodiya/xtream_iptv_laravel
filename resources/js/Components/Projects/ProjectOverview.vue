<script setup lang="ts">
import { ProjectInterface } from "@/Interfaces/main";
import { router } from "@inertiajs/vue3";
import Button from "primevue/button";
import { PropType } from "vue";

const props = defineProps({
    project: {
        type: Object as PropType<ProjectInterface>,
        required: true,
    },
});

const toggle_project_status = () => {
    const confirmed = confirm("Are you sure ?");

    if (!confirmed) {
        return;
    }

    const link = route("projects.toggle-status", {
        project_id: props.project.id,
    });

    router.post(link, {
        preserveScroll: true,
        preserveState: true,
    });
};

const delete_project = () => {
    const confirmed = confirm("Are you sure ?");

    if (!confirmed) {
        return;
    }

    const link = route("projects.delete", {
        project_id: props.project.id,
    });

    router.post(link, {
        preserveScroll: true,
        preserveState: true,
    });
};
</script>

<template>
    <div class="dark:text-gray-300 text-gray-600">
        <div class="mb-5">
            <div>
                <span
                    class="uppercase font-bold text-md dark:text-white text-black"
                    >title</span
                >
            </div>
            <div>
                <span class="text-md">{{ project.title }}</span>
            </div>
        </div>

        <div class="mb-5">
            <div>
                <span
                    class="uppercase font-bold text-md dark:text-white text-black"
                    >description</span
                >
            </div>
            <div>
                <span class="text-md">{{ project.description }}</span>
            </div>
        </div>

        <div class="mb-5">
            <div>
                <span
                    class="uppercase font-bold text-md dark:text-white text-black"
                    >broker</span
                >
            </div>
            <div>
                <span class="text-md">{{ project.broker.broker_name }}</span>
            </div>
        </div>

        <div class="mb-5">
            <div>
                <span
                    class="uppercase font-bold text-md dark:text-white text-black"
                    >data broker</span
                >
            </div>
            <div>
                <span class="text-md">{{
                    project.data_broker.broker_name
                }}</span>
            </div>
        </div>

        <div class="mb-5">
            <div>
                <span
                    class="uppercase font-bold text-md dark:text-white text-black"
                    >repository name</span
                >
            </div>
            <div>
                <span class="text-md">{{
                    project.github_repository.repository_full_name
                }}</span>
            </div>
        </div>

        <div class="mb-5">
            <div>
                <span
                    class="uppercase font-bold text-md dark:text-white text-black"
                    >clone repository</span
                >
            </div>
            <div>
                <div class="text-xs py-2">
                    <code class="space-x-2">
                        git clone
                        {{ project.github_repository.repository_ssh_url }}
                    </code>
                </div>
            </div>
        </div>

        <div class="mb-5">
            <div>
                <span
                    class="uppercase font-bold text-md dark:text-white text-black"
                    >status</span
                >
            </div>
            <div>
                <span
                    class="text-md"
                    :class="{
                        'text-green-500': project.status == 'Active',
                        'text-red-500': project.status == 'Inactive',
                    }"
                    >{{ project.status }}</span
                >
            </div>
        </div>

        <div class="flex mt-10 space-x-2">
            <Button
                :label="project.status == 'Active' ? 'Deactivate' : 'Activate'"
                severity="secondary"
                @click="toggle_project_status"
            />

            <Button label="Delete" severity="danger" @click="delete_project" />
        </div>
    </div>
</template>
