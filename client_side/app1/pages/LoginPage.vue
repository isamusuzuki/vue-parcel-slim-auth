<template>
    <div class="columns">
        <div class="column is-8">
            <div class="box">
                <h1 class="title">ログインしてください</h1>
                <div class="field">
                    <label class="label">ユーザー名</label>
                    <p class="control">
                        <input class="input" v-model="username" type="text">
                    </p>
                </div>
                <div class="field">
                    <label class="label">パスワード</label>
                    <p class="control">
                        <input class="input" v-model="password" type="password">
                    </p>
                </div>
                <div class="field">
                    <p class="control">
                        <button v-on:click="login" class="button is-link">ログイン</button>&nbsp;
                        <button v-on:click="goSignup" class="button is-text">新規登録</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            username: '',
            password: ''
        }
    },
    methods: {
        login() {
            // まずはエラーメッセージをクリアする
            this.$store.dispatch('message/clear');
            const errors = [];
            // ユーザー名は必須
            if(!this.username) {
                errors.push("ユーザー名は必須です");
            }
            // パスワード名も必須
            if(!this.password) {
                errors.push("パスワードは必須です");
            }
            // エラーがひとつでもあれば、エラーメッセージを表示する
            if (errors.length > 0) {
                this.$store.dispatch('message/error', {messages: errors});
            } else {
                // エラーなし、先に進める
                this.$store.dispatch('loader/on');
                this.$store.dispatch('auth/getToken',
                    {username: this.username, password: this.password}
                ).then(() => {
                    this.$store.dispatch('loader/off');
                    if (this.$route.query.redirect) {
                        this.$router.push({path: this.$route.query.redirect});
                    } else {
                        this.$router.push({path: this.$store.state.settings.startPage});
                    }
                }).catch(error => {
                    this.$store.dispatch('message/error',
                        {messages: ['auth/getToken 失敗', error.response.data.message]}
                    );
                    this.$store.dispatch('loader/off');
                });
            }
        },
        goSignup() {
            this.$store.dispatch('message/clear');
            this.$router.push({path: '/signup'});
        }
    }
}
</script>