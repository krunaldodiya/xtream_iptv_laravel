<script setup lang="ts">
import { AvailableBrokerInterface, BrokerInterface } from "@/Interfaces/main";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import { Head, Link, router, useForm } from "@inertiajs/vue3";
import Button from "primevue/button";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import Dropdown from "primevue/dropdown";

const props = defineProps({
    available_brokers: {
        type: Array<AvailableBrokerInterface>,
        required: true,
    },
    brokers: {
        type: Array<BrokerInterface>,
        required: true,
    },
});

const form = useForm({
    broker_id: "",
});

const configure_broker = (e: Event) => {
    const link = route("brokers.configure", {
        broker_id: form.broker_id,
    });

    router.visit(link, {
        method: "get",
        preserveState: true,
        preserveScroll: true,
    });
};

const delete_broker = (broker_id: number) => {
    const confirmed = confirm("Are you sure ?");

    if (!confirmed) {
        return;
    }

    const link = route("brokers.delete", {
        broker_id: broker_id,
    });

    router.visit(link, {
        method: "post",
        preserveState: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Brokers" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Brokers
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="shadow-sm sm:rounded-lg">
                    <div class="card flex justify-content-center">
                        <form
                            @submit.prevent="configure_broker"
                            class="flex space-x-2"
                        >
                            <Dropdown
                                v-model="form.broker_id"
                                :options="available_brokers"
                                optionLabel="name"
                                optionValue="id"
                                placeholder="Select a broker"
                                class="w-48"
                                :invalid="form.errors.broker_id ? true : false"
                            />

                            <small
                                class="text-red-500"
                                id="username-help"
                                v-if="form.errors.broker_id"
                                v-text="form.errors.broker_id"
                            />

                            <Button type="submit" label="Add Broker" />
                        </form>
                    </div>
                </div>

                <div class="mt-8">
                    <DataTable :value="brokers" tableStyle="min-width: 50rem">
                        <template #empty>
                            <div class="text-gray-400">
                                No records found
                            </div></template
                        >

                        <Column field="broker_uid" header="Unique ID"></Column>

                        <Column
                            field="broker_name"
                            header="Broker Name"
                        ></Column>

                        <Column header="Support Data ?">
                            <template #body="{ data }">
                                <i
                                    class="pi w-8 h-8"
                                    :class="{
                                        'pi-check-circle text-green-500':
                                            data.available_broker.support_data,
                                        'pi-times-circle text-red-400':
                                            !data.available_broker.support_data,
                                    }"
                                ></i
                            ></template>
                        </Column>

                        <Column header="Action">
                            <template #body="{ data }">
                                <Button
                                    icon="pi pi-trash"
                                    class="w-8 h-8"
                                    outlined
                                    rounded
                                    severity="danger"
                                    @click="delete_broker(data.id)"
                            /></template>
                        </Column>
                    </DataTable>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
