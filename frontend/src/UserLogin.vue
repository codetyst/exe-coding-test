<template>
    <div>
        <div>
            <div style="border: black 1px solid; background-color: lightyellow">{{ loginResult }}</div>
            <br />
            <b>Login</b><br />
            <label for="username-login">Username:</label>
            <input type="text" id="username-login" name="username-login" v-model="username">
            <br />
            <label for="password-login">Password:</label>
            <input :type="passwordType" id="password-login" name="password-login" v-model="password">
            <br />
            <input type="checkbox" @click="showPassword()" />
            <span>Show Password</span>
            <br />
            <button @click="login()">Test</button>
        </div>
    </div>

</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            loginResult: null,
            username: null,
            password: null,
            passwordType: 'password'
        }
    },
    methods: {
        showPassword() {
            if (this.passwordType == "password") {
                this.passwordType = "text";
            }
            else {
                this.passwordType = "password";
            }
        },
        login() {
            this.loginResult = null;
            const sign = require('jwt-encode');
            const secret = '3Qv0izEz4ohiflx3yM84J3TStnPgwzui5YJ8kjsQrpm3ru3r5AKAUxLD7iUVw28A';
            const data = {
                sub: 'login',
                username: this.username,
                password: this.password
            };
            const jwt = sign(data, secret);
            axios.post('http://localhost:2023/api/login', {
                //...data
            }, {
                headers: {
                    'Authorization': 'Bearer ' + jwt
                }
            }).then((res) => {
                this.loginResult = res.data;
            })
        }
    }
}
</script>

<style>

</style>