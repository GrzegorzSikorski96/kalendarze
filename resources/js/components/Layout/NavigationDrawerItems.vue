<template>
    <section id="sidebar-menu">
        <v-toolbar flat class="transparent" v-if="currentUser">
            <v-list class="pa-0">
                <v-list-tile avatar>
                    <v-list-tile-avatar>
                        <img src="https://randomuser.me/api/portraits/men/85.jpg">
                    </v-list-tile-avatar>

                    <v-list-tile-content>
                        <v-list-tile-title class=" font-weight-medium"> {{ currentUser.name }}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-toolbar>

        <v-divider></v-divider>

        <v-list class="pa-0">
            <v-layout v-for="visitorRoute in visitorRoutes"
                      :key="visitorRoutes.label">
                <v-flex>
                    <router-link :to="{name: visitorRoute.name}" class="route black--text">
                        <v-list-tile @click="" :ripple="{ class: 'brown--text'}">
                            <v-list-tile-action>
                                <v-icon>{{ visitorRoute.icon }}</v-icon>
                            </v-list-tile-action>

                            <v-list-tile-content>
                                <v-list-tile-title text-colo class="font-weight-medium">
                                    {{ visitorRoute.label }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </router-link>
                </v-flex>
            </v-layout>

            <v-layout v-if="currentUser" v-for="authRoute in authRoutes"
                      :key="visitorRoutes.label">
                <v-flex>
                    <router-link :to="{name: authRoute.name}" class="route black--text">
                        <v-list-tile @click="" :ripple="{ class: 'brown--text' }">
                            <v-list-tile-action>
                                <v-icon>{{ authRoute.icon }}</v-icon>
                            </v-list-tile-action>

                            <v-list-tile-content>
                                <v-list-tile-title class=" font-weight-medium">
                                    {{ authRoute.label }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </router-link>
                </v-flex>
            </v-layout>

            <v-layout v-if="currentUser && isAdmin" v-for="adminRoute in adminRoutes"
                      :key="adminRoute.label">
                <v-flex>
                    <router-link class="route black--text" :to="{name: adminRoute.name}">
                        <v-list-tile @click="" :ripple="{ class: 'brown--text' }">
                            <v-list-tile-action>
                                <v-icon>{{ adminRoute.icon }}</v-icon>
                            </v-list-tile-action>

                            <v-list-tile-content>
                                <v-list-tile-title class=" font-weight-medium">
                                    {{ adminRoute.label }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </router-link>
                </v-flex>
            </v-layout>

            <v-list-group
                    prepend-icon="today"
                    no-action
                    value="true"
                    v-if="currentUser"
            >
                <v-list-tile slot="activator">
                    <v-list-tile-title>Kalendarze</v-list-tile-title>
                </v-list-tile>

                <v-list-tile @click="addCalendar = true" color="success">
                    <v-list-tile-title>Dodaj kalendarz</v-list-tile-title>
                    <v-list-tile-action>
                        <v-icon color="success">far fa-calendar-plus</v-icon>
                    </v-list-tile-action>
                </v-list-tile>

                <v-list-tile v-for="(calendar, i) in calendars"
                             :key="i" :to="{name: 'Calendar', params: { id: calendar.id, targetCalendar: calendar}}">
                    <v-list-tile-title>{{ calendar.name }}</v-list-tile-title>
                    <v-list-tile-action>
                        <v-icon>event_note</v-icon>
                    </v-list-tile-action>
                </v-list-tile>
            </v-list-group>


            <v-layout v-if="currentUser">
                <v-flex>
                    <v-list-tile @click="logout" class="route error--text" ripple>
                        <v-list-tile-action>
                            <v-icon class="error--text">fas fa-sign-out-alt</v-icon>
                        </v-list-tile-action>

                        <v-list-tile-content>
                            <v-list-tile-title class=" font-weight-medium">
                                Wyloguj
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-flex>
            </v-layout>

            <v-layout v-else fill-height>
                <v-flex align-end>
                    <router-link :to="{name: 'Login'}" class="route success--text">
                        <v-list-tile @click="" ripple>
                            <v-list-tile-action>
                                <v-icon color="success">fas fa-sign-in-alt</v-icon>
                            </v-list-tile-action>

                            <v-list-tile-content>
                                <v-list-tile-title class=" font-weight-medium">
                                    Zaloguj
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </router-link>

                    <router-link :to="{name: 'Register'}" class="route info--text">
                        <v-list-tile @click="" ripple>
                            <v-list-tile-action>
                                <v-icon color="info">fas fa-user-plus</v-icon>
                            </v-list-tile-action>

                            <v-list-tile-content>
                                <v-list-tile-title class=" font-weight-medium">
                                    Zarejestruj
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </router-link>
                </v-flex>
            </v-layout>
        </v-list>

        <add-calendar v-if="addCalendar"></add-calendar>

    </section>
</template>

<script>
    import AddCalendar from "../Calendar/AddCalendar";
    import EditCalendar from "../Calendar/EditCalendar";
    import RemoveCalendar from "../Calendar/RemoveCalendar";
    import AddEvent from "../Event/AddEvent";

    export default {
        name: "NavigationDrawerItems",
        components: {
            AddCalendar,
            EditCalendar,
            RemoveCalendar,
            AddEvent
        },
        methods: {
            logout() {
                this.$store.commit('logout');
                this.$router.push('/login');
            },
            fetchCalendars() {
                this.$store.dispatch('getCalendars');
            },
        },
        mounted() {
            if (this.currentUser) {
                this.$store.dispatch('getCalendars');
            }
        },
        data: () => ({
            drawer: true,
            addCalendar: false,
            authRoutes: [],
            visitorRoutes: [
                {label: 'Strona główna', name: 'HomePage', icon: 'home'},
            ],
        }),
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
            isAdmin() {
                return this.$store.getters.isAdmin;
            },
            calendars() {
                return this.$store.getters.getCalendars;
            },
        },
        watch: {
            currentUser() {
                this.fetchCalendars();
            }
        }
    }
</script>

<style scoped>
    .route {
        text-decoration: none;
    }
</style>