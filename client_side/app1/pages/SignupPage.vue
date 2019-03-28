<template>
    <div class="columns">
        <div class="column is-8">
            <div class="box">
                <h1 class="title">新規登録する</h1>
                <div class="field">
                    <label class="label">ユーザー名</label>
                    <p class="control">
                        <input class="input" v-model="username" type="text" placeholder="英数字のみ">
                    </p>
                </div>
                <div class="field">
                    <label class="label">パスワード</label>
                    <p class="control">
                        <input class="input" v-model="password" type="password" placeholder="4文字以上">
                    </p>
                </div>
                <div class="field">
                    <label class="label">確認のためもう一度</label>
                    <p class="control">
                        <input class="input" v-model="confPassword" type="password" placeholder="上と同じであること">
                    </p>
                </div>
                <div class="field">
                    <p class="control">
                        <button v-on:click="signup" class="button is-link">登録</button>&nbsp;
                        <button v-on:click="goLogin" class="button is-text">ログインに戻る</button>
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
            password: '',
            confPassword: ''
        }
    },
    methods: {
        signup() {
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
            } else {
                // パスワードの長さは4文字以上
                if(this.password.length < 4) {
                    errors.push("パスワードは4文字以上");
                }
            }
            // 確認用パスワード名も必須
            if(!this.confPassword) {
                errors.push("確認用パスワードは必須です");
            } else {
                // パスワードと確認用パスワードが異なったらエラー
                if(this.confPassword !== this.password) {
                    errors.push("パスワードと確認用パスワードが異なっています");
                }
            }
            // エラーがひとつでもあれば、エラーメッセージを表示する
            if (errors.length > 0) {
                this.$store.dispatch('message/error', {messages: errors});
            } else {
                // エラーなし、先に進める
                this.$store.dispatch('loader/on');
                this.$store.dispatch('auth/signup',
                    {username: this.username, password: this.password}
                ).then(response => {
                    this.$store.dispatch('loader/off');
                    this.username = '';
                    this.password = '';
                    this.confPassword = '';
                    this.$store.dispatch('message/success',
                        {messages: [response.data.message]}
                    );
                }).catch(error => {
                    this.$store.dispatch('message/error',
                        {messages: ['auth/signup 失敗', error.response.data.message]}
                    );
                    this.$store.dispatch('loader/off');
                });
            }
        },
        goLogin() {
            this.$store.dispatch('message/clear');
            this.$router.push({path: '/login'});
        }
    }
}
</script>
