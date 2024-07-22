<script setup lang="ts">
import { ProjectInterface } from "@/Interfaces/main";
import { Link, useForm } from "@inertiajs/vue3";
import Button from "primevue/button";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import { PropType } from "vue";
import SecretInput from "./SecretInput.vue";
import { useToast } from "primevue/usetoast";

const props = defineProps({
    project: {
        type: Object as PropType<ProjectInterface>,
        required: true,
    },
});

const form = useForm({});
const toast = useToast();

const regenerate_algo_session_secret = (algo_session_id: string) => {
    const confirmed = confirm("Are you sure ?");

    if (!confirmed) {
        return;
    }

    const url = route("algo-sessions.regenerate-secret", {
        algo_session_id: algo_session_id,
    })

    form.post(url,{
        preserveScroll: true,
        preserveState: true,
        onFinish: (data) => {
            toast.add({
                severity: "success",
                summary: "Success",
                detail: "algo session key and secret regenrated",
            });
        }
    });
};
</script>

<template>
    <DataTable :value="project.algo_sessions" tableStyle="min-width: 50rem">
        <template #empty>
            <div class="text-gray-400">No records found</div></template
        >

        <Column field="mode" header="Mode"></Column>
        <Column field="key" header="Key"></Column>
        <Column header="Secret">
            <template #body="{ data }">
                <SecretInput :secret="data.secret" />
            </template>
        </Column>

        <Column header="Action" class="space-x-2">
            <template #body="{ data }">
                <Button
                    icon="pi pi-lock"
                    class="w-8 h-8"
                    outlined
                    rounded
                    severity="warning"
                    @click="regenerate_algo_session_secret(data.id)"
                />

                <Link :href="route('algo-sessions.overview', {algo_session_id: data.id})">
                    <Button
                        icon="pi pi-eye"
                        class="w-8 h-8"
                        outlined
                        rounded
                        severity="success"
                    />
                </Link>
            </template>
        </Column>
    </DataTable>
</template>
