<script setup lang="ts">
import AlgoSessionInfoOverview from "@/Components/AlgoSessions/AlgoSessionInfoOverview.vue";
import { AlgoSessionInterface } from "@/Interfaces/main";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { PropType } from "vue";

const props = defineProps({
    algo_session: {
        type: Object as PropType<AlgoSessionInterface>,
        required: true,
    },
});

const form = useForm({
    algo_session_id: props.algo_session.id,
});

const submit = (e: Event) => {
    form.post(
        route("algo-sessions.start-container", { id: form.algo_session_id })
    );
};
</script>

<template>
    <Head title="Overview" />

    <AuthenticatedLayout>
        <template #header>
            <AlgoSessionInfoOverview
                :algo_session_id="algo_session.id"
                title="Overview"
            />
        </template>

        <div class="py-12">
            <div class="mb-10 space-x-2 text-black dark:text-white">Overview</div>
                <div class="text-black dark:text-white">
                    <div class="mb-5">
                    <div><span class="text-md uppercase text-green-200">title</span></div>
                    <div>
                        <span class="text-sm text-gray-800 dark:text-gray-200">{{
                        algo_session.project.title
                        }}</span>
                    </div>
                    </div>

                    <div class="mb-5">
                    <div><span class="text-md uppercase text-green-200">broker</span></div>
                    <div>
                        <span class="text-sm text-gray-800 dark:text-gray-200">{{
                        algo_session.project.broker.broker_name
                        }}</span>
                    </div>
                    </div>

                    <div class="mb-5">
                    <div>
                        <span class="text-md uppercase text-green-200">data broker</span>
                    </div>
                    <div>
                        <span class="text-sm text-gray-800 dark:text-gray-200">{{
                        algo_session.project.data_broker.broker_name
                        }}</span>
                    </div>
                    </div>

                    <div class="mb-5">
                    <div>
                        <span class="text-md uppercase text-green-200">repository name</span>
                    </div>
                    <div>
                        <span class="text-sm text-gray-800 dark:text-gray-200">{{
                        algo_session.project.github_repository.repository_full_name
                        }}</span>
                    </div>
                    </div>

                    <div class="mb-5">
                    <div>
                        <span class="text-md uppercase text-green-200">mode</span>
                    </div>
                    <div>
                        <span class="text-sm text-gray-800 dark:text-gray-200">{{
                        algo_session.mode
                        }}</span>
                    </div>
                    </div>
                </div>
        </div>
    </AuthenticatedLayout>
</template>