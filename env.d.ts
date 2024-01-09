/// <reference types="vite/client" />

interface ImportMetaEnv {
    readonly VITE_BACKEND_URL: string
    readonly VITE_FRONTEND_PORT: string
    readonly VITE_FRONTEND_URL: string

    // more env variables...
}

interface ImportMeta {
    readonly env: ImportMetaEnv
}

declare module "*.vue" {
    import type { DefineComponent } from "vue";
    const component: DefineComponent<object, object, any>;
    export default component;
}
