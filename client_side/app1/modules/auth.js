import axios from 'axios';

export default {
    namespaced: true,
    state: {
        username: '',
        token: '',
        hasToken: false,
        key: 'vpsa-auth'
    },
    mutations: {
        update (state, payload) {
            state.username = payload.username;
            state.token = payload.token;
            state.hasToken = state.token.length > 0;
        }
    },
    actions: {
        getToken (context, payload) {
            return new Promise((resolve, reject) => {
                axios.post(`${context.rootState.settings.serverUrl}/auth`,
                    payload
                ).then(response => {
                    // 成功
                    const newAuth = {username: payload.username, token: response.data.token};
                    context.commit('update', newAuth);
                    localStorage.setItem(context.state.key, JSON.stringify(newAuth));
                    resolve();
                }).catch(error => {
                    // 失敗
                    reject(error);
                });
            });
        },
        loadToken (context) {
            if(localStorage.getItem(context.state.key)) {
                const currentAuth = JSON.parse(localStorage.getItem(context.state.key));
                context.commit('update', currentAuth);
            }
        },
        clear (context) {
            const emptyAuth = {username: '', token: ''};
            context.commit('update', emptyAuth);
            localStorage.removeItem(context.state.key);
        }
    }
}
