<template>
    <v-flex xs12 sm6 offset-sm3>
        <v-card class="rounded-card" elevation="10">
            <vue-event-calendar :events="events">
                <template slot-scope="props">
                    <v-card v-for="(event, index) in props.showEvents" :key="index" class="event-item">
                        <v-card-title>
                            <div class="text-sm-left">
                                <span class="grey--text ">{{ event.title }}</span><br>
                                <span>{{ event.desc }}</span>
                            </div>
                        </v-card-title>
                    </v-card>
                </template>
            </vue-event-calendar>
        </v-card>
        <v-btn @click="addEvent(calendar)"
                fixed
                dark
                fab
                top
                right
                color="pink"
        >
            <v-icon>add</v-icon>
        </v-btn>

        <add-event v-if="addEventDialog" :calendar="calendar"></add-event>
    </v-flex>
</template>

<script>
    import AddEvent from "../Event/AddEvent";

    export default {
        data() {
            return {
                events: [],
                calendar: {},
                addEventDialog: false,
            }
        },
        components:{
            AddEvent
        },
        methods: {
            fetchEvents() {
                this.$http.get(`/api/calendar/${this.$route.params.id}/events`).then((response) => {
                    this.$store.commit("refreshToken", response.data.token);
                    this.events = response.data.data.events
                });
            },
            handleDayChanged(data) {
                console.log('date-changed', data)
            },
            addEvent(calendar) {
                this.calendar = Object.assign({}, calendar);
                this.addEventDialog = true;
            },
            handleMonthChanged(data) {
                console.log('month-changed', data)
            }
        },
        mounted() {
            setTimeout(() => {
                this.fetchEvents();
            }, 300);
        },
        watch: {
            $route(to, from) {
                this.fetchEvents();
            }
        }
    }
</script>

<style>
    .rounded-card {
        border-radius: 50px;
    }
</style>
