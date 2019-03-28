<template>
    <aside class="menu is-hidden-mobile" v-if="isDisplay">
        <p class="menu-label">
            <span class="icon"><i class="fas fa-play-circle"></i></span>
            新規作成
        </p>
        <ul class="menu-list">
            <li><a v-on:click="goInput" v-bind:class="{'is-active': currentPage == 'input'}">会議を始める</a></li>
        </ul>
        <p class="menu-label">
            <span class="icon"><i class="fas fa-phone-square"></i></span>
            ただいま会議中
        </p>
        <p class="menu-label">
            <span class="icon"><i class="fas fa-cog"></i></span>    
            設定
        </p>
        <ul class="menu-list">
            <li><a v-on:click="goPhonebook" v-bind:class="{'is-active': currentPage == 'phonebook'}">電話帳</a></li>
            <li><a v-on:click="goRestcomm" v-bind:class="{'is-active': currentPage == 'restcomm'}">Restcomm API</a></li>
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
        goInput() {

        },
        goPhonebook() {

        },
        goRestcomm() {

        }
    }
}
</script>
