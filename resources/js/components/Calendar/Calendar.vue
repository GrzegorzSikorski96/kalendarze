<template>
    <v-flex xs12 sm6 offset-sm3>
        <v-card class="rounded-card" elevation="10">
            <vue-event-calendar :events="events">
                <template slot-scope="props">
                    <!--<v-card v-for="(event, index) in props.showEvents" :key="index" class="event-item">
                        <v-card-title>
                            <div class="text-sm-left">
                                <span class="grey&#45;&#45;text ">{{ event.title }}</span><br>
                                <span>{{ event.desc }}</span>
                                <v-btn
                                        fab
                                        dark
                                        small
                                        color="success"
                                        @click="editEvent(event)"
                                >
                                    <v-icon>edit</v-icon>
                                </v-btn>
                                <v-btn
                                        fab
                                        dark
                                        small
                                        color="error"
                                        @click="removeEvent(event)"
                                >
                                    <v-icon>delete</v-icon>
                                </v-btn>
                            </div>
                        </v-card-title>
                    </v-card>-->

                    <v-card v-for="(event, index) in props.showEvents" :key="index" class="event-item">
                        <v-card-title primary-title>
                            <div>
                                <h3 class="headline mb-0">{{ event.title }}</h3>
                                <div>{{ event.desc }}</div>
                            </div>
                        </v-card-title>

                        <v-card-actions v-if="isOwner">
                            <v-spacer></v-spacer>
                            <v-btn @click="editEvent(event)" icon>
                                <v-icon color="success">edit</v-icon>
                            </v-btn>
                            <v-btn @click="removeEvent(event)" icon>
                                <v-icon color="error">delete</v-icon>
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </template>
            </vue-event-calendar>
        </v-card>
        <v-speed-dial
                v-if="isOwner"
                top
                right
                fixed
                direction="bottom"
                transition="slide-y-transition"
        >
            <v-btn
                    slot="activator"
                    color="#314b49"
                    dark
                    fab
            >
                <v-icon>account_circle</v-icon>
                <v-icon>close</v-icon>
            </v-btn>
            <v-btn
                    fab
                    dark
                    small
                    color="success"
                    @click="addEvent(calendar)"
            >
                <v-icon>event</v-icon>
            </v-btn>
            <v-btn
                    fab
                    dark
                    small
                    color="info"
                    @click="editCalendar(calendar)"
            >
                <v-icon>edit</v-icon>
            </v-btn>
            <v-btn
                    fab
                    dark
                    small
                    color="error"
                    @click="removeCalendar(calendar)"
            >
                <v-icon>delete</v-icon>
            </v-btn>
        </v-speed-dial>

        <add-calendar v-if="addCalendarDialog"></add-calendar>
        <edit-calendar v-if="editCalendarDialog" :calendar="calendar"></edit-calendar>
        <remove-calendar v-if="removeCalendarDialog" :calendar="calendar"></remove-calendar>
        <add-event v-if="addEventDialog" :calendar="calendar"></add-event>
        <edit-event v-if="editEventDialog" :event="event"></edit-event>
        <remove-event v-if="removeEventDialog" :event="event"></remove-event>
    </v-flex>
</template>

<script>
    import AddEvent from "../Event/AddEvent";
    import EditCalendar from "./EditCalendar";
    import RemoveCalendar from "./RemoveCalendar";
    import AddCalendar from "./AddCalendar";
    import EditEvent from "../Event/EditEvent";
    import RemoveEvent from "../Event/RemoveEvent";

    export default {
        name: 'Calendar',
        components: {
            AddCalendar,
            AddEvent,
            EditCalendar,
            RemoveCalendar,
            EditEvent,
            RemoveEvent
        },
        methods: {
            async fetchEvents() {
                this.$http.get(`/api/calendar/${this.$route.params.id}/events`).then((response) => {
                    this.$store.commit("refreshToken", response.data.token);
                    this.events = response.data.data.events
                });
            },
            async fetchCalendar() {
                this.$http.get(`/api/calendar/${this.$route.params.id}`).then((response) => {
                    this.$store.commit("refreshToken", response.data.token);
                    this.calendar = response.data.data.calendar;
                });
            },
            async fetchCalendars() {
                this.$store.dispatch('getCalendars');
            },
            handleDayChanged(data) {
                console.log('date-changed', data)
            },
            handleMonthChanged(data) {
                console.log('month-changed', data)
            },
            addEvent(calendar) {
                this.targetCalendar = Object.assign({}, calendar);
                this.addEventDialog = true;
            },
            editCalendar(calendar) {
                this.targetCalendar = Object.assign({}, calendar);
                this.editCalendarDialog = true;
            },
            removeCalendar(calendar) {
                this.targetCalendar = Object.assign({}, calendar);
                this.removeCalendarDialog = true;
            },
            editEvent(event) {
                this.event = Object.assign({}, event);
                this.editEventDialog = true;
            },
            removeEvent(event) {
                this.event = Object.assign({}, event);
                this.removeEventDialog = true;
            },

        },
        computed:{
            isOwner()
            {
                return !!(this.$store.getters.isLoggedIn && (this.$store.getters.currentUser.id === this.calendar.owner_id));
            }
        },
        data: () => ({
            events: [],
            calendar: {},
            event: {},
            addCalendarDialog: false,
            addEventDialog: false,
            editCalendarDialog: false,
            removeCalendarDialog: false,
            editEventDialog: false,
            removeEventDialog: false
        }),
        mounted() {
            setTimeout(() => {
                this.fetchEvents();
            }, 300);
            setTimeout(() => {
                this.fetchCalendar();
            }, 800);
        },
        watch: {
            $route(to, from) {
                setTimeout(() => {
                    this.fetchEvents();
                }, 300);
                setTimeout(() => {
                    this.fetchCalendar();
                }, 800);
            },

        }
    }
</script>

<style>
    .rounded-card {
        border-radius: 50px;
    }
</style>
