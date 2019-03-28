<template>
    <aside class="menu is-hidden-mobile" v-if="isDisplay">
        <p class="menu-label">
            <span class="icon"><i class="fas fa-play-circle"></i></span>
            メニュー
        </p>
        <ul class="menu-list">
            <li><a v-on:click="goTop" v-bind:class="{'is-active': currentPage == 'home'}">ホーム</a></li>
            <li><a v-on:click="goSecond" v-bind:class="{'is-active': currentPage === 'second'}">セカンド</a></li>
        </ul>
    </aside>
</template>

<script>
export default {
    computed: {
        isDisplay() {
            return this.$store.state.auth.hasToken;
        },
        currentPage() {
            return this.$store.state.currentPage.name;
        }
    },
    methods: {
        goTop() {
            this.$router.push({path: '/home'});
        },
        goSecond() {
            this.$router.push({path: '/second'});
        }
    }
}
</script>
