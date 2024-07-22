import { defineStore } from "pinia";

type RootState = {
    token: string | null;
    user: { [type: string]: any } | null;
};

export const useAuthStore = defineStore({
    id: "authStore",
    state: (): RootState => ({
        token: null,
        user: null,
    }),
    actions: {
        set_auth(data: { token: string; user: { [type: string]: number } }) {
            this.token = data.token;
            this.user = data.user;
        },
        unset_auth() {
            this.token = null;
            this.user = null;
        },
        set_user(user: { [type: string]: number }) {
            this.user = user;
        },
    },
    persist: true,
});
