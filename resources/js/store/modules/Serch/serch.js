const state = {
    types: [],
    marks: [],
    models: [],
    regions: [],
    years: [],
    result: [],
};

const getters = {
    types: state => {
        return state.types
    },
    marks: state => {
        return state.marks
    },
    models: state => {
        return state.models
    },
    regions: state => {
        return state.regions
    },
    years: state => {
        return state.years
    },
    result: state => {
        return state.result
    }

};

const mutations = {

    set_types: (state, payload) => {
        state.types = payload;
    },
    set_marks: (state, payload) => {
        state.marks = payload;
    },
    set_models: (state, payload) => {
        state.models = payload;
    },
    set_regions: (state, payload) => {
        state.regions = payload;
    },
    set_years: (state, payload) => {
        state.years = payload;
    },
    set_result: (state, payload) => {
        state.result = payload;
    },
};

const actions = {
    select_types: ({commit}) => {
        axios.get('api/prop/type/').then(response => {
            if (response.data) {
                commit('set_types', response.data);
            } else {
                commit('set_types', []);
            }
        });
    },
    select_marks: ({commit}, type) => {
        axios.get('api/prop/mark/', {params: {type: type}}).then(response => {
            if (response.data) {
                commit('set_marks', response.data);
            } else {
                commit('set_marks', []);
            }
        });
    },
    select_models: ({commit}, prop) => {
        axios.get('api/prop/model/', {params: {mark: prop['mark'], type: prop['type']}})
            .then(response => {
                if (response.data) {
                    commit('set_models', response.data);
                } else {
                    commit('set_models', []);
                }
            });
    },
    select_regions: ({commit}) => {
        axios.get('api/prop/region/').then(response => {
            if (response.data) {
                commit('set_regions', response.data);
            } else {
                commit('set_regions', []);
            }
        });
    },
    select_years: ({commit}) => {
        var temp_years = []
        for (var i = (new Date()).getFullYear(); i >= 1900; i--) {
            temp_years.push(i)
        }
        commit('set_years', temp_years)
    },
    select_result: ({commit}, prop) => {
        axios.get('api/search/', {
            params: {
                mark: prop['mark'],
                type: prop['type'],
                model: prop['model'],
                region: prop['region'],
                year_begin: prop['year_begin'],
                year_and: prop['year_and'],
            }
        }).then(response => {
            if (response.data) {
                commit('set_result', response.data);
            } else {
                commit('set_result', []);
            }
        });
    },
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
};
