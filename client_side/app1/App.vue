<template>
    <div>
        <nav-menu></nav-menu>
        <div class="container">
            <div class="columns">
                <div class="column is-3">
                    <side-menu></side-menu>
                </div>
                <div class="column is-9">
                    <message-notice></message-notice>
                    <router-view></router-view>
                </div>
            </div>
        </div>
        <loading-modal></loading-modal>
    </div>
</template>

<script>
import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
// コンポーネンツ群をインポートする
import LoadingModal from './components/LoadingModal';
import MessageNotice from './components/MessageNotice';
import NavMenu from './components/NavMenu';
import SideMenu from './components/SideMenu';
// モジュール群をインポートする
import auth from './modules/auth';
import currentPage from './modules/currentPage';
import loader from './modules/loader';
import message from './modules/message';
// ページ群をインポートする
import HomePage from './pages/HomePage';
import LoginPage from './pages/LoginPage';
import SecondPage from './pages/SecondPage';
import SignupPage from './pages/SignupPage';

// 設定値を決める
const settings = {
    namespaced: true,
    state: {
        startPage: '/home',
        serverUrl: location.host === 'localhost:1234' ? 'http://localhost:80' : ''
    }
}

// Vuexを設定する
Vue.use(Vuex);
const store = new Vuex.Store({
    modules: {
        auth,
        currentPage,
        loader,
        message,
        settings
    }
});

// Vue-Routerを設定する
Vue.use(VueRouter);
const router = new VueRouter({
    routes: [
        {path: '/login', component: LoginPage},
        {path: '/signup', component: SignupPage},
        {path: '/home', component: HomePage, meta: {requiresAuth: true}},
        {path: '/second', component: SecondPage, meta: {requiresAuth: true}}
    ]
});
router.beforeEach(function(to, from, next) {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.state.auth.hasToken) {
            next({path: '/login', query: {redirect: to.fullPath}});
        } else {
            next();
        }
    } else {
        next();
    }
});

// 親コンポーネントを設定する
export default {
    router,
    store,
    components: {
        'loading-modal': LoadingModal,
        'message-notice': MessageNotice,
        'nav-menu': NavMenu,
        'side-menu': SideMenu
    },
    mounted() {
        this.$store.dispatch('auth/loadToken');
        this.$router.replace(this.$store.state.settings.startPage);
    }
}
</script>

<style>
@import '../node_modules/bulma/css/bulma.min.css';

html, body {
    height: 100%;
    background: #ECF0F3;
}
</style>