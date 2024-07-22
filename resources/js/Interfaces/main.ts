interface UserInterface {
    id: number;
    name: string;
    email: string;
    created_at: string;
    updated_at: string;
}

interface PlanInterface {
    id: number;
    name: string;
    description: string;
    maximum_projects: number;
    can_paper_trade: boolean;
    can_live_trade: string;
    monthly_charges: number;
    currency: string;
    created_at: string;
    updated_at: string;
}

interface UserPlanInterface {
    id: number;
    user_id: number;
    plan_id: number;
    plan_status: string;
    plan: PlanInterface;
    expires_at: string;
    created_at: string;
    updated_at: string;
}

interface PlanSubscriptionInterface {
    id: number;
    user_id: number;
    plan: PlanInterface;
    order_type: string;
    order_id: string;
    currency: string;
    amount: number;
    meta: object;
    status: string;
    created_at: string;
    updated_at: string;
}

export type {
    PlanInterface,
    UserPlanInterface,
    PlanSubscriptionInterface,
};
