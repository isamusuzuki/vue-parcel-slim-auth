<template>
    <div class="box page-box">
        <h1 class="title">サーバーサイドで、トークンのペイロード（中身）を解析する</h1>
        <div class="field">
            <p class="control">
                <button v-on:click="analyze" class="button is-link">実行</button>
            </p>
        </div>
        <div class="field">
            <label class="label">解析結果</label>
            <p class="control">
                <textarea class="textarea is-medium" rows="10" v-model="payload"></textarea>
            </p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            payload: ''
        }
    },
    mounted() {
        this.$store.dispatch('currentPage/replace', {name: 'second'});
    },
    methods: {
        analyze() {
            this.$store.dispatch('loader/on');
            this.$store.dispatch('auth/getPayload').then(response => {
                this.payload = JSON.stringify(response.data, null, 2);
                this.$store.dispatch('loader/off');
            }).catch(error => {
                this.$store.dispatch('message/error',
                    {messages: ['auth/getPayload 失敗', error.response.data]}
                );
                this.$store.dispatch('loader/off');
            })
        }
    }
}
</script>