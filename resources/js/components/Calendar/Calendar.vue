<!--<template>
    <v-flex fill-height class="bg">
        <FullCalendar :events="events" :config="config"></FullCalendar>
    </v-flex>
</template>

<script>
    import { FullCalendar } from 'vue-full-calendar'
    export default {
        components: {
            FullCalendar,
        },
        methods:{
            fetchEvents(){
                axios.get(`/api/calendar/${this.$route.params.id}/events`, {
                    headers: {
                        "Authorization": `Bearer ${this.$store.getters.currentUser.token}`
                    },
                }).then((response) => {
                    this.$store.commit("refreshToken", response.data.token);
                    this.events = response.data.data.events
                });
            }
        },
        mounted(){
            this.fetchEvents();
        },
        data() {
            return {
                events: [],
                config: {
                    nowIndicator: true,
                    height: "auto",
                    locale: 'pl',
                    slotLabelFormat:"HH:mm"
                },
            }
        },
        watch:{
            $route (to, from){
                this.fetchEvents();
            }
        }
    }
</script>-->

<style lang="scss">
    .bg {
        background: white;
    }
</style>

<template>
    <v-flex xs12 sm6 offset-sm3>
        <v-card class="rounded-card" elevation="10">
            <vue-event-calendar :events="events">
                <!--<template slot-scope="props">
                    <div v-for="(event, index) in props.showEvents" class="event-item">
                        &lt;!&ndash; In here do whatever you want, make you owner event template &ndash;&gt;
                        {{event}}
                    </div>
                </template>-->
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
    </v-flex>

</template>

<script>
    export default {
        data() {
            return {
                events: []
            }
        },
        methods: {
            async fetchEvents() {
                axios.get(`/api/calendar/${this.$route.params.id}/events`, {
                    headers: {
                        "Authorization": `Bearer ${this.$store.getters.currentUser.token}`
                    },
                }).then((response) => {
                    this.$store.commit("refreshToken", response.data.token);
                    this.events = response.data.data.events
                });
            },
            handleDayChanged(data) {
                console.log('date-changed', data)
            }
            ,
            handleMonthChanged(data) {
                console.log('month-changed', data)
            }
        },
        mounted() {
            this.fetchEvents();
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