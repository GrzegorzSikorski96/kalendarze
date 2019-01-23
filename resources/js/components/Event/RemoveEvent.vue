<template>
    <v-dialog v-model="$parent.removeEventDialog" max-width="500px">
        <v-card>
            <v-card-text>
                <h1 class="brown--text">Usuń wydarzenie</h1>
                <v-container grid-list-md>
                    Czy napewno chcesz usunąć wydarzenie <strong>{{ event.title }}</strong>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red darken-1" flat @click="remove()">Usuń</v-btn>
                <v-btn color="darken-1" flat @click="$parent.removeEventDialog = false">Anuluj</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: "RemoveEvent",
        props: {
            event: {type: Object},
        },
        methods: {
            remove() {
                this.$http.delete(`/api/event/${this.event.id}/remove`)
                    .then(response => {
                        this.$store.commit("refreshToken", response.data.token);
                        this.$parent.fetchEvents();

                        this.$toasted.show('Usunięto wydarzenie', {
                            type: 'success'
                        });
                    })
                    .catch(error => {
                        this.$toasted.show('Nie udało się usunąć wydarzenia', {
                            type: 'error'
                        });
                    });
                this.$parent.removeEventDialog = false;
            },
        }
    }
</script>

<style scoped>

</style>