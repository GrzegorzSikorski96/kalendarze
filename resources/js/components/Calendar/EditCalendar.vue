<template>
    <v-dialog v-model="$parent.editCalendarDialog" max-width="500px">
        <v-card>
            <v-card-text>
                <h1 class="brown--text">Edytuj Kalendarz</h1>
                <v-container grid-list-md>
                    <v-form @keyup.native.enter="save()" class="form">
                        <v-text-field
                                v-validate.in="'required'"
                                v-model="calendar.name"
                                :error-messages="errors.collect('nazwa')"
                                label="Nazwa"
                                data-vv-name="nazwa"
                                required>
                        </v-text-field>

                        <v-text-field
                                v-validate.in="'required'"
                                v-model="calendar.description"
                                :error-messages="errors.collect('opis')"
                                label="Opis"
                                data-vv-name="opis"
                                required>
                        </v-text-field>

                        <v-checkbox
                                v-model="calendar.is_private"
                                label="Prywatny"
                        ></v-checkbox>
                    </v-form>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="success darken-1" flat @click="edit()">Zapisz</v-btn>
                <v-btn color="red darken-1" flat @click="$parent.editCalendarDialog = false">Anuluj</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: "EditCalendar",
        data: () => ({}),
        props: {
            calendar: {type: Object},
        },
        methods: {
            edit() {
                this.$validator.validate().then(result => {
                    if (result) {
                        let data = {
                            name: this.calendar.name,
                            description: this.calendar.description,
                            is_private: this.calendar.is_private,
                        };

                        this.$http.post(`/api/calendar/${this.calendar.id}/edit`, data)
                            .then(response => {
                                this.$store.commit("refreshToken", response.data.token);
                                this.$parent.fetchCalendars();


                                this.$toasted.show('Edytowano kalendarz', {
                                    type: 'success'
                                });
                            })
                            .catch(error => {
                                this.$toasted.show('Nie udało się edytować kalendarza', {
                                    type: 'error'
                                });
                            })
                    }
                });
                this.$parent.editCalendarDialog = false;
            },
        }
    }
</script>

<style scoped>

</style>