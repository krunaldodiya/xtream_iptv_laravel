import { defineStore } from "pinia";

type RootState = {
    data: any;
};

export const useLtpStore = defineStore({
    id: "ltpStore",
    state: (): RootState => ({
        data: {},
    }),
    actions: {
        set_ltp(key: string, value: any) {
            this.data[key] = value;
        },
    },
    persist: true,
});
