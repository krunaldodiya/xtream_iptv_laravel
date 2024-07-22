interface UserInterface {
    id: number;
    name: string;
    email: string;
    created_at: string;
    updated_at: string;
}
interface AvailableBrokerInterface {
    id: number;
    title: string;
    name: string;
    created_at: string;
    updated_at: string;
}

interface BrokerInterface {
    id: number;
    broker_title: string;
    broker_name: string;
    broker_config: { [key: string]: string | number };
    created_at: string;
    updated_at: string;
}

interface GithubAccountInterface {
    id: number;
    type: string;
    username: string;
    account_id: number;
    created_at: string;
    updated_at: string;
}

interface GithubRepositoryInterface {
    id: number;
    repository_id: string;
    repository_owner: string;
    repository_name: string;
    repository_full_name: string;
    repository_ssh_url: string;
    github_account_id: number;
    github_account: GithubAccountInterface;
    created_at: string;
    updated_at: string;
}

interface ProjectInterface {
    id: number;
    title: string;
    description: string;
    status: string;
    user_id: number;
    owner: UserInterface;
    broker_id: number;
    broker: BrokerInterface;
    data_broker_id: number;
    data_broker: BrokerInterface;
    github_repository_id: number;
    github_repository: GithubRepositoryInterface;
    algo_sessions: AlgoSessionInterface[];
    created_at: string;
    updated_at: string;
}

interface AlgoSessionInterface {
    id: number;
    mode: string;
    secret: string;
    expires_at: string;
    status: string;
    key: string;
    created_at: string;
    updated_at: string;
    project: ProjectInterface
}

interface OrderInterface {
    id: number;
    algo_session_id: number;
    user_id: number;
    order_id: string;
    segment_type: string;
    position_type: string;
    order_type: string;
    product_type: string;
    price: number;
    quantities: number;
    status: string;
    created_at: string;
    updated_at: string;
}

interface PositionInterface {
    id: number;
    algo_session_id: number;
    user_id: number;
    position_id: string;
    segment_type: string;
    position_type: string;
    order_type: string;
    product_type: string;
    quantities: number;
    enter_price: number;
    exit_price: number;
    status: string;
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
    ProjectInterface,
    AvailableBrokerInterface,
    GithubAccountInterface,
    GithubRepositoryInterface,
    BrokerInterface,
    AlgoSessionInterface,
    OrderInterface,
    PositionInterface,
    PlanInterface,
    UserPlanInterface,
    PlanSubscriptionInterface,
};
