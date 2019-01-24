import Vue from "vue"
import Router from "vue-router"
import Login from "./components/Auth/Login";
import HomePage from "./components/HomePage/HomePage";
import Register from "./components/Auth/Register";
import Calendar from "./components/Calendar/Calendar";

Vue.use(Router);

export default new Router({
    mode: "history",

    routes: [
        {
            path: '/',
            name: 'HomePage',
            component: HomePage,
        },
        {
            path: '/login',
            name: 'Login',
            component: Login,
            meta: {
                forVisitors: true,
            }
        },
        {
            path: '/register',
            name: 'Register',
            component: Register,
            meta: {
                forVisitors: true,
            }
        },
        {
            path: '/calendar/:id',
            name: 'Calendar',
            component: Calendar,
            props: true
        }
    ]
})