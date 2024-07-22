<script setup lang="ts">
import { PropType } from "vue";

import { Head, useForm } from "@inertiajs/vue3";

import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { AvailableBrokerInterface } from "@/Interfaces/main";
import Button from "primevue/button";

const props = defineProps({
    available_broker: {
        type: Object as PropType<AvailableBrokerInterface>,
        required: true,
    },
});

const form = useForm({
    client_id: "",
    totp_key: "",
    pin: "",
    api_key: "",
    api_secret: "",
});

const submit = (e: Event) => {
    const link = route("brokers.store", {
        broker_id: props.available_broker.id,
    });

    form.transform((data) => ({ ...data, uid: data.client_id })).post(link, {
        preserveScroll: true,
        preserveState: true,
    });
};
</script>

<template>
    <Head :title="available_broker.name" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                {{ available_broker.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="submit">
                    <div class="mb-5">
                        <InputLabel htmlFor="client_id" value="Client ID" />

                        <TextInput
                            type="text"
                            id="client_id"
                            name="client_id"
                            placeholder="AB12345"
                            class="w-96 border-gray-300 rounded-md shadow-sm"
                            :class="form.errors.client_id && 'border-red-500'"
                            isFocused="true"
                            v-model="form.client_id"
                        />

                        <InputError
                            :message="form.errors.client_id"
                            class="mt-2"
                        />
                    </div>

                    <div class="mb-5">
                        <InputLabel htmlFor="totp_key" value="TOTP KEY" />

                        <TextInput
                            type="text"
                            id="totp_key"
                            name="totp_key"
                            placeholder="TOTP KEY"
                            class="w-96 border-gray-300 rounded-md shadow-sm"
                            :class="form.errors.totp_key && 'border-red-500'"
                            isFocused="true"
                            v-model="form.totp_key"
                        />

                        <InputError
                            :message="form.errors.totp_key"
                            class="mt-2"
                        />
                    </div>

                    <div class="mb-5">
                        <InputLabel htmlFor="pin" value="PIN" />

                        <TextInput
                            type="text"
                            id="pin"
                            name="pin"
                            placeholder="PIN"
                            class="w-96 border-gray-300 rounded-md shadow-sm"
                            :class="form.errors.pin && 'border-red-500'"
                            isFocused="true"
                            v-model="form.pin"
                        />

                        <InputError :message="form.errors.pin" class="mt-2" />
                    </div>

                    <div class="mb-5">
                        <InputLabel htmlFor="api_key" value="API Key" />

                        <TextInput
                            type="text"
                            id="api_key"
                            name="api_key"
                            placeholder="API Key"
                            class="w-96 border-gray-300 rounded-md shadow-sm"
                            :class="form.errors.api_key && 'border-red-500'"
                            isFocused="true"
                            v-model="form.api_key"
                        />

                        <InputError
                            :message="form.errors.api_key"
                            class="mt-2"
                        />
                    </div>

                    <div class="mb-5">
                        <InputLabel htmlFor="api_secret" value="API Secret" />

                        <TextInput
                            type="text"
                            id="api_secret"
                            name="api_secret"
                            placeholder="API Secret"
                            class="w-96 border-gray-300 rounded-md shadow-sm"
                            :class="form.errors.api_secret && 'border-red-500'"
                            isFocused="true"
                            v-model="form.api_secret"
                        />

                        <InputError
                            :message="form.errors.api_secret"
                            class="mt-2"
                        />
                    </div>

                    <Button
                        class="mt-5 w-96 border-gray-300 rounded-md shadow-sm"
                        type="submit"
                        :disabled="form.processing"
                    >
                        {{
                            form.processing ? "Loading..." : "Add Broker"
                        }}</Button
                    >
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
