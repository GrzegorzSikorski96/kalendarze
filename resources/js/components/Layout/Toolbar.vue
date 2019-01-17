<template>
    <v-toolbar color="#ab8464" dense dark fixed app class="navbar">
        <slot></slot>
        <router-link class="title" :to="{name: 'HomePage'}">
            <v-toolbar-title class="title white--text" fill-width>
                Kalendarze
            </v-toolbar-title>
        </router-link>

        <v-spacer>
        </v-spacer>

        <!--<v-toolbar-items class="hidden-sm-and-down">
            <template v-if="!currentUser">
                <v-btn flat :to="{ name: 'Login' }" class="route white&#45;&#45;text">
                    Zaloguj
                </v-btn>

                <v-btn flat :to="{ name: 'Register' }" class="route white&#45;&#45;text">
                    Zarejestruj
                </v-btn>
            </template>

            <template v-else>
                <v-btn flat :to="{ name: 'Panel' }" v-if="isAdmin" class="route white&#45;&#45;text">
                    Panel
                </v-btn>

                <v-btn flat class="white&#45;&#45;text" @click="logout">
                    Wyloguj
                </v-btn>
            </template>
        </v-toolbar-items>-->
    </v-toolbar>
</template>

<script>
    export default {
        methods: {
            isAdmin() {
                return currentUser.role.name === 'ADMIN' || currentUser.role.name === 'SUPERADMIN';
            }
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            }
        },
    }
</script>

<style lang="scss">
    .title {
        font-weight: bold;
        text-decoration: none;
    }

    .route {
        text-decoration: none;
    }
</style>