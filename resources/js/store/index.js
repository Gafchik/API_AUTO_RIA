import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);
import Serch from './modules/Serch/serch';

export default new Vuex.Store({
    modules: {
    serch: Serch,
    }
});
