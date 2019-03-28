<template>
    <div class="box page-box">
        <div class="content">
            <h1>都道府県</h1>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        this.$store.dispatch('currentPage/replace', {name: 'prefectures'});
    }
}
</script>