<script setup>
import { ref, computed } from 'vue'
import router from '../plugins/router'

const drawer = ref(null)
const currentRoutes = computed(() => router.getRoutes().sort((a, b) => a.meta.order - b.meta.order));

</script>


<style lang="scss" scoped>
.v-col .loader {
    min-height: 250px;
}
</style>

<template>
    <v-app id="lvef-examples">
        <v-navigation-drawer app v-model="drawer" permanent mini-variant expand-on-hover left :mini-variant.sync="mini">
            <v-sheet color="grey-lighten-4" class="pa-4">
                <div>Laravel Vue EasyForms Examples</div>
            </v-sheet>
            <v-divider />
            <v-list>
                <v-list-item v-for="route of currentRoutes" :key="route.name" :title="route.name" :to="route.path" />
            </v-list>
        </v-navigation-drawer>
        <v-main app>
            <router-view class="py-2 px-10" />
        </v-main>
    </v-app>
</template>
