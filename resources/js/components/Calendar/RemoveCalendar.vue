<template>
    <v-dialog v-model="$parent.removeCalendarDialog" max-width="500px">
        <v-card>
            <v-card-text>
                <h1 class="brown--text">Usuń Kalendarz</h1>
                <v-container grid-list-md>
                    Czy napewno chcesz usunąć kalendarz <strong>{{ calendar.name }}</strong>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red darken-1" flat @click="remove()">Usuń</v-btn>
                <v-btn color="darken-1" flat @click="$parent.removeCalendarDialog = false">Anuluj</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: "RemoveCalendar",
        props: {
            calendar: {type: Object},
        },
        methods: {
            remove() {
                this.$http.delete(`/api/calendar/${this.calendar.id}/remove`)
                    .then(response => {
                        this.$store.commit("refreshToken", response.data.token);
                        this.$parent.fetchCalendars();
                        this.$parent.events = [];
                        this.$router.push({ name: 'HomePage'})

                        this.$toasted.show('Usunięto kalendarz', {
                            type: 'success'
                        });
                    })
                    .catch(error => {
                        this.$toasted.show('Nie udało się usunąć kalendarza', {
                            type: 'error'
                        });
                    });
                this.$parent.removeCalendarDialog = false;
            },
        }
    }
</script>

<style scoped>

</style>