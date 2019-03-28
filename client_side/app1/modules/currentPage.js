export default {
    namespaced: true,
    state: {
        name: '',
    },
    mutations: {
        replace (state, name) {
            state.name = name;
        }
    },
    actions: {
        replace (context, payload) {
            context.commit('replace', payload.name);
        },
        clear (context) {
            context.commit('replace', '');
        }
    }
}