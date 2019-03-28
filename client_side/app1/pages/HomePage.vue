<template>
    <div class="box page-box">
        <div class="content">
            <h1>ここはログイン認証に成功してからでないと表示されないページです</h1>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        this.$store.dispatch('currentPage/replace', {name: 'home'});
    }
}
</script>

<style>
.box.page-box {
    min-height: 500px;
}
</style>