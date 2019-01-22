import Vue from "vue"
import Vuex from "vuex"
import {getLocalUser} from './helpers/auth';
import axios from "axios";

Vue.use(Vuex);

const user = getLocalUser();

export default new Vuex.Store({
    state: {
        currentUser: user,
        isLoggedIn: !!user,
        loading: false,
        auth_error: null,
        calendars: []
    },
    getters: {
        isLoading(state) {
            return state.loading;
        },
        isLoggedIn(state) {
            return state.isLoggedIn;
        },
        currentUser(state) {
            return state.currentUser;
        },
        authError(state) {
            return state.auth_error;
        },
        isAdmin(state) {
            return state.currentUser && (state.currentUser.role.name === "ADMIN" || state.currentUser.role.name === "SUPERADMIN");
        },
        getCalendars(state) {
            return state.calendars;
        }
    },
    mutations: {
        login(state) {
            state.loading = true;
            state.auth_error = null;
        },
        loginSuccess(state, payload) {
            state.auth_error = null;
            state.isLoggedIn = true;
            state.loading = false;
            state.currentUser = Object.assign({}, payload.data.user, {token: payload.token});

            localStorage.setItem("user", JSON.stringify(state.currentUser));
        },
        loginFailed(state, payload) {
            state.loading = false;
            state.auth_error = payload.error;
        },
        logout(state) {
            localStorage.removeItem("user");
            state.isLoggedIn = false;
            state.currentUser = null;
            state.calendars = [];
        },
        register(state) {
            state.loading = true;
            state.auth_error = null;
        },
        registerFailed(state, payload) {
            state.loading = false;
            state.auth_error = payload.error;
        },
        registerSuccess(state, payload) {
            state.auth_error = null;
            state.loading = false;
        },
        updateCalendars(state, payload) {
            state.calendars = payload.data.calendars;
        },
        refreshToken(state, payload) {
            state.currentUser.token = payload;
            localStorage.setItem("user", JSON.stringify(state.currentUser));
        }
    },
    actions: {
        login(context) {
            context.commit("login");
        },
        register(context) {
            context.commit("register");
        },
        getCalendars(context) {
            axios.get('/api/auth/calendars', {
                headers: {
                    "Authorization": `Bearer ${context.state.currentUser.token}`
                }
            }).then((response) => {
                context.commit('updateCalendars', response.data);
                this.commit('refreshToken', payload.token);
            });
        },
    }
})