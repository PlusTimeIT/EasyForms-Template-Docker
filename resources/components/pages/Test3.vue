<script setup lang="ts">

import axios from 'axios';
import { ref } from 'vue';

import { AdditionalData } from 'laravel-vue-easyforms/properties';

interface User {
    username: string;
    first_name: string;
    email: string;
    status: string;
}

const userList = ref<User[]>([]);
const results = axios.get('/api/users')
    .then((response) => {
        userList.value = response.data;
    })
    .catch((error) => {
        console.log(error);
    });

</script>

<template>
    <v-sheet>
        <v-row>
            <v-col>
                <h1>[ Action Form ] User List</h1>
            </v-col>
        </v-row>
        <v-row>
            <v-table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <tr v-for="(user, index) in userList" :key="index">
                        <td>{{ index }}</td>
                        <td>{{ user.username }}</td>
                        <td>{{ user.first_name }}</td>
                        <td>{{ user.email }}</td>
                        <td>
                            <FormLoader name="Action\User\ListActions" :additional-data="[{ key: 'id', value: index }]" />
                        </td>
                    </tr>
                </tbody>
            </v-table>
        </v-row>
    </v-sheet>
</template>
