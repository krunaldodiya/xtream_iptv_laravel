<script setup lang="ts">
import { useToast } from "primevue/usetoast";

import {
    PlanInterface,
    PlanSubscriptionInterface,
    UserPlanInterface,
} from "@/Interfaces/main";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import { Head, router, useForm } from "@inertiajs/vue3";
import Button from "primevue/button";
import { PropType, ref } from "vue";

const toast = useToast();

const props = defineProps({
    razorpay_key: {
        type: String,
        required: true,
    },
    plans: {
        type: Array<PlanInterface>,
        required: true,
    },
    user_plan: {
        type: Object as PropType<UserPlanInterface>,
        required: true,
    },
    flash: {
        type: Object,
        required: true,
    },
    plan_subscription: {
        type: Object as PropType<PlanSubscriptionInterface>,
        required: false,
    },
});

const loadRazorpay = async (src: string) => {
    return new Promise((resolve, reject) => {
        const script = document.createElement("script");
        script.src = src;
        document.body.appendChild(script);
        script.onload = resolve;
        script.onerror = reject;
    });
};

const showRazorpay = async (response: any) => {
    const { plan_subscription, auth } = response.props;

    await loadRazorpay("https://checkout.razorpay.com/v1/checkout.js");

    const razorpay = new Razorpay({
        key_id: props.razorpay_key,
        name: "Subscribe Plan",
        description: "subscribe to the plan.",
        order_id: plan_subscription.order_id,
        handler: (data: any) => {
            store_plan_subscription({ ...data, plan_subscription });
        },
        prefill: {
            name: auth.name,
            email: auth.email,
        },
        theme: {
            color: "#3399cc",
        },
    });

    razorpay.open();
};

const form = useForm({
    plan_id: props.user_plan.plan_id,
});

const flash_message = ref(props.flash.message ?? null);

const subscribe_to_plan = (plan_id: number) => {
    form.plan_id = plan_id;

    form.post(route("plan-subscriptions.store"), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (data) => {
            if (data.props.plan_subscription) {
                showRazorpay(data);
            } else {
                toast.add({
                    severity: "warn",
                    summary: "Error",
                    detail: props.flash.message,
                });

                flash_message.value = null;
            }
        },
        onFinish: () => {
            form.reset();
        },
    });
};

const store_plan_subscription = (response: any) => {
    router.post(
        route("plan-subscriptions.process"),
        { ...response, plan_id: response.plan_subscription.plan_id },
        {
            preserveScroll: true,
            preserveState: true,
            onSuccess: async (response: any) => console.log(response),
        }
    );
};

const get_choose_plan_action = (plan_id: number) => {
    if (
        plan_id == props.user_plan.plan_id &&
        props.user_plan.plan_status == "expired"
    ) {
        return "renew";
    }

    if (
        plan_id == props.user_plan.plan_id &&
        props.user_plan.plan_status == "active"
    ) {
        return "current";
    }

    return "choose";
};
</script>

<template>
    <Head title="Wallet" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Pricing
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-10">
                <div class="container mx-auto">
                    <div class="flex flex-wrap">
                        <div class="w-full px-4">
                            <div
                                class="mx-auto mb-[60px] max-w-[510px] text-center"
                            >
                                <h2
                                    class="mb-10 text-3xl leading-[1.208] font-bold text-black dark:text-white sm:text-4xl md:text-[40px]"
                                >
                                    Our Pricing Plans
                                </h2>

                                <p
                                    class="text-base text-body-color dark:text-gray-300"
                                >
                                    Find the perfect plan for your needs,
                                    whether you're just starting out or leading
                                    a large organization. Our flexible pricing
                                    options ensure you get the right tools and
                                    support at every stage.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap justify-center">
                        <div
                            class="w-full px-2 md:w-1/2 lg:w-1/4"
                            v-for="plan in plans"
                        >
                            <form
                                @submit.prevent="
                                    () => subscribe_to_plan(plan.id)
                                "
                            >
                                <div
                                    class="rounded-md border border-gray-300 hover:bg-gray-200 dark:hover:bg-gray-800 py-10 px-8 cursor-pointer"
                                >
                                    <span
                                        class="mb-3 block text-lg font-semibold text-primary"
                                    >
                                        {{ plan.name }}
                                    </span>
                                    <h2
                                        class="mb-5 text-[36px] font-bold text-black dark:text-white"
                                    >
                                        <span
                                            >{{ plan.currency }}
                                            {{ plan.monthly_charges }}</span
                                        >
                                        <span
                                            class="text-base font-medium text-body-color dark:text-gray-300"
                                        >
                                            / month
                                        </span>
                                    </h2>
                                    <p
                                        class="h-36 mb-8 pb-8 border-b border-stroke border-gray-300 dark:border-gray-500 dark:text-gray-300 text-sm"
                                    >
                                        {{ plan.description }}
                                    </p>
                                    <div class="mb-9 flex flex-col gap-[14px]">
                                        <p
                                            class="text-base text-body-color dark:text-gray-300"
                                        >
                                            <i class="pi w-8 h-8 pi-book"></i>
                                            <span
                                                >{{
                                                    plan.maximum_projects
                                                }}
                                                Projects</span
                                            >
                                        </p>

                                        <p
                                            class="text-base text-body-color dark:text-gray-300"
                                        >
                                            <i
                                                class="pi w-8 h-8"
                                                :class="{
                                                    'pi-check-circle text-green-500':
                                                        plan.can_paper_trade,
                                                    'pi-times-circle text-red-400':
                                                        !plan.can_paper_trade,
                                                }"
                                            ></i>
                                            <span>Paper Trading</span>
                                        </p>

                                        <p
                                            class="text-base text-body-color dark:text-gray-300"
                                        >
                                            <i
                                                class="pi w-8 h-8"
                                                :class="{
                                                    'pi-check-circle text-green-500':
                                                        plan.can_live_trade,
                                                    'pi-times-circle text-red-400':
                                                        !plan.can_live_trade,
                                                }"
                                            ></i>
                                            <span>Live Trading</span>
                                        </p>

                                        <p
                                            class="text-base text-body-color dark:text-gray-300"
                                        >
                                            <i
                                                class="pi w-8 h-8 pi-headphones"
                                            ></i>
                                            <span>24*7 support</span>
                                        </p>
                                    </div>

                                    <Button
                                        type="submit"
                                        class="w-full font-bold text-white dark:text-black"
                                        :disabled="
                                            get_choose_plan_action(plan.id) ==
                                            'current'
                                        "
                                    >
                                        <span class="capitalize"
                                            >{{
                                                get_choose_plan_action(plan.id)
                                            }}
                                        </span>
                                    </Button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
