<script setup lang="ts">
import { GithubRepositoryInterface } from "@/Interfaces/main";
import { router } from "@inertiajs/vue3";
import Button from "primevue/button";
import Column from "primevue/column";
import DataTable from "primevue/datatable";

const props = defineProps({
    github_repositories: {
        type: Array<GithubRepositoryInterface>,
        required: true,
    },
});

const delete_github_repository = (github_repository_id: number) => {
    const confirmed = confirm("Are you sure ?");

    if (!confirmed) {
        return;
    }

    const link = route("github-repositories.delete", {
        github_repository_id: github_repository_id,
    });

    router.visit(link, {
        method: "post",
        preserveState: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <DataTable :value="github_repositories" tableStyle="min-width: 50rem">
        <template #empty>
            <div class="text-gray-400">No records found</div></template
        >

        <Column
            field="repository_full_name"
            header="Github Repository"
        ></Column>

        <Column header="Action">
            <template #body="{ data }">
                <Button
                    icon="pi pi-trash"
                    class="w-8 h-8"
                    outlined
                    rounded
                    severity="danger"
                    @click="delete_github_repository(data.id)"
            /></template>
        </Column>
    </DataTable>
</template>
