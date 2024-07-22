<script setup lang="ts">
import { GithubAccountInterface } from "@/Interfaces/main";
import { router } from "@inertiajs/vue3";
import Button from "primevue/button";
import Column from "primevue/column";
import DataTable from "primevue/datatable";

const props = defineProps({
    github_accounts: {
        type: Array<GithubAccountInterface>,
        required: true,
    },
});

const revoke_github_account = (github_account_id: number) => {
    const confirmed = confirm("Are you sure ?");

    if (!confirmed) {
        return;
    }

    const link = route("github-accounts.delete", {
        github_account_id: github_account_id,
    });

    router.visit(link, {
        method: "post",
        preserveState: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <DataTable :value="github_accounts" tableStyle="min-width: 50rem">
        <template #empty>
            <div class="text-gray-400">No records found</div></template
        >

        <Column field="username" header="Github Account"></Column>

        <Column header="Action">
            <template #body="{ data }">
                <Button
                    icon="pi pi-trash"
                    class="w-8 h-8"
                    outlined
                    rounded
                    severity="danger"
                    @click="revoke_github_account(data.id)"
            /></template>
        </Column>
    </DataTable>
</template>
