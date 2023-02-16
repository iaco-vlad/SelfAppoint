import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate'

export default new Vuex.Store({
    state: {
        token: null,
        user: null
    },
    mutations: {
        setLoginCredentials(state, credentials) {
            console.log('test');
            console.log(credentials);
            this.state.token = credentials.token;
            this.state.token = credentials.user;
        },
    },
    actions: {
        setLoginCredentials({ commit }, credentials) {
            commit('setLoginCredentials', credentials);
        },
    },
    plugins: [
        createPersistedState({
            storage: window.sessionStorage,
            paths: ['token']
        })
    ]
});
