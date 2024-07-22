<script setup lang="ts">
import { onMounted } from "vue";

import { Head, useForm, usePage } from "@inertiajs/vue3";

import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const form = useForm({
    message: "",
});

const submit = (e: Event) => {
    form.post(route("message.store"), {
        preserveScroll: true,
        preserveState: true,
    });
};

onMounted(() => {
    const page = usePage();

    window.Echo.private(`App.Models.User.${page.props.auth.user.id}`).listen(
        "MessageCreated",
        (event: Event) => {
            console.log(event);
        }
    );
});
</script>

<template>
    <Head title="Welcome" />
    <form @submit.prevent="submit">
        <div class="mb-4">
            <InputLabel htmlFor="message" value="Write a message" />

            <TextInput
                type="text"
                id="message"
                name="message"
                placeholder="Write a message"
                class="w-96 border-gray-300 rounded-md shadow-sm"
                :class="form.errors.message && 'border-red-500'"
                isFocused="true"
                v-model="form.message"
            />

            <InputError :message="form.errors.message" class="mt-2" />
        </div>

        <PrimaryButton
            class="w-96 mt-2 px-4 py-2 bg-red-500 font-bold text-white outline-none text-auto items-center justify-center"
            :disabled="form.processing"
        >
            {{ form.processing ? "Loading..." : "Send Message" }}
        </PrimaryButton>
    </form>
</template>
