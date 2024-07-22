import { defineStore } from "pinia";

type RootState = {
    is_dark: boolean;
};

export const useThemeStore = defineStore({
    id: "themeStore",
    state: (): RootState => ({
        is_dark: true,
    }),
    actions: {
        toggle_dark_mode() {
            this.is_dark = !this.is_dark;
        },
    },
    persist: true,
});
