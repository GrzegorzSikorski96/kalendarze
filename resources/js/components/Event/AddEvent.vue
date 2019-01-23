<template>
    <v-dialog v-model="$parent.addEventDialog" max-width="500px">
        <v-card>
            <v-card-text>
                <h1 class="brown--text">Dodaj Wydarzenie</h1>
                <v-container grid-list-md>
                    <v-form @keyup.native.enter="save()" class="form">
                        <v-text-field
                                v-validate.in="'required'"
                                v-model="title"
                                :error-messages="errors.collect('nazwa')"
                                label="Nazwa"
                                data-vv-name="title"
                                required>
                        </v-text-field>

                        <v-text-field
                                v-validate.in="'required'"
                                v-model="description"
                                :error-messages="errors.collect('opis')"
                                label="Opis"
                                data-vv-name="opis"
                                required>
                        </v-text-field>

                        <v-menu
                                :close-on-content-click="false"
                                :nudge-right="40"
                                lazy
                                transition="scale-transition"
                                offset-y
                                full-width
                                min-width="290px"
                        >
                            <v-text-field
                                    slot="activator"
                                    v-model="date"
                                    label="Picker without buttons"
                                    prepend-icon="event"
                                    readonly
                            ></v-text-field>
                            <v-date-picker v-model="date"></v-date-picker>
                        </v-menu>
                    </v-form>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="success darken-1" flat @click="add()">Zapisz</v-btn>
                <v-btn color="red darken-1" flat @click="$parent.addEventDialog = false">Anuluj</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: "AddEvent",
        data() {
            return {
                dialog: true,
                title: null,
                description: null,
                date: null,
            }
        },
        props: {
            calendar: {type: Object},
        },
        methods: {
            add() {

                alert(this.calendar.id)
                this.$validator.validate().then(result => {
                    if (result) {
                        let data = {
                            title: this.title,
                            desc: this.description,
                            date: this.date,
                        };

                        this.$http.post(`/api/calendar/${this.calendar.id}/event/create`, data)
                            .then(response => {
                                this.$store.commit("refreshToken", response.data.token);
                                this.$parent.fetchEvents();
                            })
                            .catch(error => {
                                alert(response.data)
                                /*this.announcementAddFailedMessage();*/
                            })
                    }
                });
                this.$parent.addCalendar = false;
            },
        },
    }
</script>

<style scoped>

</style>