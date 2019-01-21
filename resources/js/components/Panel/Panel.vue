<template>
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
              axios.get('/api/events', {
                  headers: {
                      "Authorization": `Bearer ${this.$store.getters.currentUser.token}`
                  },
              }).then((response) => {
                  this.$store.commit("refreshToken", response.data.token);
                  alert(this.events = response.data.data.events)
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
        }
    }
</script>

<style lang="scss">
    .bg{
        background: white;
    }
</style>