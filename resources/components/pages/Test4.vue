<script setup lang="ts">

import { useRoute } from 'vue-router';

const route = useRoute()

const additionalData = [{ key: 'id', value: route.params.id }];
</script>

<template>
    <v-sheet>
        <v-row>
            <v-col>
                <h1>[ Input Form ] Edit User</h1>
            </v-col>
        </v-row>
        <v-row>
            <v-col>Load Form from Server action icons
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <FormLoader name="Input\User\EditUser"  :additional-load-data="additionalData" :additional-data="additionalData"/>
            </v-col>
        </v-row>
    </v-sheet>
</template>
