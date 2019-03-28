<template>
    <nav class="navbar is-white">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item brand-text" v-on:click="goStart">vue-parcel-slim-auth</a>
                <div class="navbar-item is-hidden-desktop">
                    <login-status></login-status>
                </div>
            </div>
            <div class="navbar-menu">
                <div class="navbar-end">
                    <div class="navbar-item">
                        <login-status></login-status>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import LoginStatus from './LoginStatus';

export default {
    components: {
        'login-status': LoginStatus,
    },
    methods: {
        goStart() {
            this.$router.push(this.$store.state.settings.startPage);
        }
    }
}
</script>

<style scoped>
nav.navbar {
    border-top: 4px solid hsl(217, 71%, 53%);
    margin-bottom: 1rem;
}
.navbar-item.brand-text {
    font-size: 16pt;
    font-weight: 600;
}
</style>