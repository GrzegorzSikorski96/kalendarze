<template>
    <v-dialog v-model="$parent.removeCalendarDialog" max-width="500px">
        <v-card>
            <v-card-text>
                <h1 class="brown--text">Usuń Kalendarz</h1>
                <v-container grid-list-md>
                    Czy napewno chcesz usunąć kalendarz <strong>{{ calendarToRemove.name }}</strong>
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
            calendarToRemove: {type: Object},
        },
        methods: {
            remove() {
                this.$http.delete(`/api/calendar/${this.calendarToRemove.id}/remove`, {
                    headers: {
                        "Authorization": `Bearer ${this.$store.getters.currentUser.token}`
                    },
                })
                    .then(response => {
                        this.$store.commit("refreshToken", response.data.token);
                        this.$parent.fetchCalendars();
                    })
                    .catch(error => {
                        /*this.announcementAddFailedMessage();*/
                    });
                this.$parent.removeCalendarDialog = false;
            },
        }
    }
</script>

<style scoped>

</style>