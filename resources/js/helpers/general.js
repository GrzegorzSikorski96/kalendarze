import Axios from 'axios';

export function initialize(store, router) {
    router.beforeEach((to, from, next) => {
        const currentUser = store.state.currentUser;

        if (to.matched.some(record => record.meta.forVisitors)) {
            if (currentUser) {
                next({
                    path: "/"
                })
            } else next();
        } else if (to.matched.some(record => record.meta.forAdmins)) {
            if (currentUser.role.name !== "ADMIN" && currentUser.role.name !== "SUPERADMIN") {
                next({
                    path: "/"
                })
            } else next();
        } else next();
    });

    Axios.interceptors.response.use(null, (error => {
        if (error.response.status === 401) {
            store.commit('logout');
            router.push('/login');
        }
    }));

    if (store.getters.currentUser) {
        setAuthorization(store.getters.currentUser.token);
    }
}

export function setAuthorization(token) {
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
    axios.defaults.headers.common["Access-Control-Allow-Origin"] = '*';
}