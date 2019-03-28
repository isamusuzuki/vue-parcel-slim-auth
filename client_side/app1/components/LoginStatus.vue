<template>
    <div v-if="isDisplay">
        <span class="icon">
            <i class="fas fa-user"></i>
        </span>
        {{ username }}さん
        &nbsp;
        <a v-on:click="logOut">
            ログアウト
            <span class="icon"><i class="fas fa-sign-out-alt"></i>
        </span>
        </a>
    </div>
</template>

<script>
export default {
    computed: {
        isDisplay() {
            return this.$store.state.auth.hasToken;
        },
        username() {
            return this.$store.state.auth.username;
        }
    },
    methods: {
        logOut() {
            this.$store.dispatch('auth/clear');
            this.$store.dispatch('currentPage/clear');
            this.$router.push({path: '/login'});
        }
    }
}
</script>