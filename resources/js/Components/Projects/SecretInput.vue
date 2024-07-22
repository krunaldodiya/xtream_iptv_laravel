<script setup lang="ts">
import Button from "primevue/button";
import { reactive } from "vue";

const props = defineProps({
    secret: {
        required: true,
        type: String,
    },
});

const data = reactive({
    visible: false,
    secret: props.secret,
});

const hide = () => {
    data.visible = false;
};

const show = () => {
    data.visible = true;

    setTimeout(() => {
        data.visible = false;
    }, 10000);
};
</script>

<template>
    <div class="flex">
        <div class="w-96">
            <span v-if="!data.visible">********************************</span>
            <span v-if="data.visible">{{ data.secret }}</span>
        </div>

        <div class="space-x-2">
            <Button v-if="data.visible" @click="hide()" class="w-16 h-6"
                >hide</Button
            >
            <Button v-if="!data.visible" @click="show()" class="w-16 h-6"
                >show</Button
            >
        </div>
    </div>
</template>
