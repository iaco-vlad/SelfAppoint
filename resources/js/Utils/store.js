import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate'

export default new Vuex.Store({
    state: {
        token: null,
        user: null
    },
    mutations: {
        setLoginCredentials(state, credentials) {
            if (credentials === null) {
                state.token = state.user = null;
                return;
            }
            state.token = credentials.token;
            state.user = credentials.user;
        },
    },
    actions: {
        setLoginCredentials({commit}, credentials) {
            commit('setLoginCredentials', credentials);
        },
        logout({commit}) {
            commit('setLoginCredentials', null);
        }
    },
    plugins: [
        createPersistedState({
            storage: window.sessionStorage,
            paths: ['token', 'user']
        })
    ],
    getters: {
        isAuthenticated: state => {
            return !!state.token;
        },
    }
});
