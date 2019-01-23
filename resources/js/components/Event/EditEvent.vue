<template>
    <v-dialog v-model="$parent.editEventDialog" max-width="500px">
        <v-card>
            <v-card-text>
                <h1 class="brown--text">Edytuj Wydarzenie</h1>
                <v-container grid-list-md>
                    <v-form @keyup.native.enter="edit()" class="form">
                        <v-text-field
                                v-validate.in="'required'"
                                v-model="event.title"
                                :error-messages="errors.collect('nazwa')"
                                label="Nazwa"
                                data-vv-name="title"
                                required>
                        </v-text-field>

                        <v-text-field
                                v-validate.in="'required'"
                                v-model="event.desc"
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
                            <v-date-picker locale="pl" v-model="date"></v-date-picker>
                        </v-menu>
                    </v-form>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="success darken-1" flat @click="edit()">Zapisz</v-btn>
                <v-btn color="red darken-1" flat @click="$parent.editEventDialog = false">Anuluj</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: "EditEvent",
        data: () => ({
            date: null,
        }),
        props: {
            event: {type: Object},
        },
        methods: {
            edit() {
                this.$validator.validate().then(result => {
                    if (result) {
                        let data = {
                            title: this.event.title,
                            desc: this.event.desc,
                            date: this.date,
                        };

                        this.$http.post(`/api/event/${this.event.id}/edit`, data)
                            .then(response => {
                                this.$store.commit("refreshToken", response.data.token);
                                this.$parent.fetchEvents();

                                this.$toasted.show('Edytowano wydarzenie', {
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
        },
        created(){
            this.date = this.moment(new Date(this.event.date)).toISOString().substr(0, 10)
        },
    }
</script>

<style scoped>

</style>