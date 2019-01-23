<template>
    <v-dialog v-model="$parent.addCalendar" max-width="500px">
        <v-card>
            <v-card-text>
                <h1 class="brown--text">Dodaj Kalendarz</h1>
                <v-container grid-list-md>
                    <v-form @keyup.native.enter="save()" class="form">
                        <v-text-field
                                v-validate.in="'required'"
                                v-model="name"
                                :error-messages="errors.collect('nazwa')"
                                label="Nazwa"
                                data-vv-name="nazwa"
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

                        <v-checkbox
                                v-model="private"
                                label="Prywatny"
                        ></v-checkbox>
                    </v-form>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="success darken-1" flat @click="create()">Zapisz</v-btn>
                <v-btn color="red darken-1" flat @click="$parent.addCalendar = false">Anuluj</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import Vue from 'vue'

    export default {
        name: "AddCalendar",
        data() {
            return {
                name: null,
                description: null,
                private: true,
            }
        },
        methods: {
            create() {
                this.$validator.validate().then(result => {
                    if (result) {
                        let data = {
                            name: this.name,
                            description: this.description,
                            is_private: this.private,
                        };

                        this.$http.post("/api/calendar/create", data)
                            .then(response => {
                                this.$store.commit("refreshToken", response.data.token);
                                this.$parent.fetchCalendars();


                                Vue.toasted.show('Dodano kalendarz', {
                                    type: 'success'
                                });
                            })
                            .catch(error => {
                                Vue.toasted.show('Nie udało się dodać kalendarza', {
                                    type: 'error'
                                });
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