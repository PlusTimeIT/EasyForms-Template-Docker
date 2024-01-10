import 'vue-router'

export {}

declare module 'vue-router' {
    interface RouteMeta {
        order: number
        show: boolean
    }
}
