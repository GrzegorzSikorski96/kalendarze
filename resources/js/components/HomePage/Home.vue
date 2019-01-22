<template>
    <v-container fill-height class="container">
        <v-layout align-center>
            <v-flex xs12 sm6 offset-sm3>
                <v-card color="#e8e7c9" elevation="10">
                    <v-card-text class="brown--text">
                        <h1>
                            {{ quote.text }}
                        </h1>
                    </v-card-text>
                    <v-card-title class="brown--text author">
                        <h3>
                            {{ quote.author }}
                        </h3>
                    </v-card-title>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    export default {
        name: "Home",
        computed: {
            quote() {
                return this.randomQuote();
            }
        },
        data: () => ({
            quotes: [
                {
                    text: "Wszyscy powinniśmy troszczyć się o przyszłość, bo w niej spędzimy resztę życia.",
                    author: "Charles Kettering"
                },
                {
                    text: "Twój czas jest ograniczony, więc nie marnuj go na byciem kimś, kim nie jesteś.",
                    author: "Steve Jobs"
                },
                {
                    text: "Zegar i kalendarz nie powinny przysłaniać faktu, iż każda chwila życia jest cudem i tajemnicą.",
                    author: "Robin Sharma"
                },
                {
                    text: "Na ważne rzeczy nie można \"Znajdować czasu\". Musi on być zarezerwowany w kalendarzu.",
                    author: "Timothy Ferriss"
                },
                {
                    text: "Najpiękniejszych chwil w życiu nie zaplanujesz. One przyjdą same.",
                    author: "Phil Bosmans"
                },
            ],
        }),
        methods: {
            randomQuote() {
                return this.quotes[Math.floor(Math.random() * this.quotes.length)];
            },
        }
    }
</script>

<style>
    h1 {
        font-size: 2rem;
    }

    .author {
        font-style: italic;
    }
</style>