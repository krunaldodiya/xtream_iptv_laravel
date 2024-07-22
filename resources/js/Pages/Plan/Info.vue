<script setup lang="ts">
import { DateTime } from "luxon";

import {
    PlanSubscriptionInterface,
    UserPlanInterface,
} from "@/Interfaces/main";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import { Head } from "@inertiajs/vue3";
import { PropType } from "vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";

const props = defineProps({
    user_plan: {
        type: Object as PropType<UserPlanInterface>,
        required: true,
    },
    plan_subscriptions: {
        type: Array<PlanSubscriptionInterface>,
        required: true,
    },
    plan_subscription: {
        type: Object as PropType<PlanSubscriptionInterface>,
        required: false,
    },
});
</script>

<template>
    <Head title="Wallet" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Plan Info
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-10">
                <div class="dark:text-white text-black font-bold text-2xl mb-5">
                    My Plan
                </div>

                <div class="dark:text-white text-black">
                    <div class="flex">
                        <div class="w-24">Plan Name</div>
                        <div>{{ user_plan.plan.name }}</div>
                    </div>

                    <div class="flex">
                        <div class="w-24">Expires At</div>
                        <div>
                            {{
                                DateTime.fromISO(user_plan.expires_at).toFormat(
                                    "yyyy-MM-dd HH:mm:ss"
                                )
                            }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-10">
                <div class="dark:text-white text-black font-bold text-2xl mb-5">
                    Payment History
                </div>

                <div>
                    <DataTable
                        :value="plan_subscriptions"
                        tableStyle="min-width: 50rem"
                    >
                        <template #empty>
                            <div class="text-gray-400">
                                No records found
                            </div></template
                        >

                        <Column field="order_id" header="Order ID"></Column>

                        <Column header="Plan">
                            <template #body="{ data }">
                                <span>{{ data.plan.name }}</span>
                            </template>
                        </Column>

                        <Column header="Amount" class="space-x-1">
                            <template #body="{ data }">
                                <span>{{ data.currency }}</span>
                                <span>{{
                                    Number(data.amount).toFixed(2)
                                }}</span>
                            </template>
                        </Column>

                        <Column header="Datetime">
                            <template #body="{ data }">
                                <span>{{
                                    DateTime.fromISO(data.created_at).toFormat(
                                        "yyyy-MM-dd HH:mm:ss"
                                    )
                                }}</span>
                            </template>
                        </Column>

                        <Column field="status" header="Status"></Column>
                    </DataTable>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
