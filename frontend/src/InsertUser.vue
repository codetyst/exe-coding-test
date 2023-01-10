<template>
    <div>
        <div style="border: black 1px solid; background-color: lightyellow">{{ result }}</div>
        <br />
        <b>Insert</b><br />
        (* means required field)<br />
        <label for="name">* Name: </label>
        <input type="text" id="name" name="name" v-model="name"><br />
        <label for="phone">* Phone: </label>
        <input type="text" id="phone" name="phone" v-model="phone"><br />
        <label for="email">* Email: </label>
        <input type="text" id="email" name="email" v-model="email"><br />
        <label for="password">* Password: </label>
        <input :type="passwordType" id="password" name="password" v-model="password"><br />
        <input type="checkbox" @click="showPassword()" />
        <span>Show Password</span>
        <br />
        <label for="username">* Username: </label>
        <input type="text" id="username" name="username" v-model="username"><br />
        <label for="company">* Company: </label>
        <input type="text" id="company" name="company" v-model="company"><br />
        <label for="nationality">* Nationality: </label>
        <input type="text" id="nationality" name="nationality" v-model="nationality"><br />
        <br />
        <button @click="insert()">Insert</button>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            result: null,
            name: null,
            phone: null,
            email: null,
            password: null,
            username: null,
            company: null,
            nationality: null,
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
        insert() {
            this.result = null;
            const data = {
                name: this.name,
                phone: this.phone,
                email: this.email,
                password: this.password,
                username: this.username,
                company: this.company,
                nationality: this.nationality,
            };
            axios.post('http://localhost:2023/api/user', data,)
                .then((res) => {
                    this.result = res.data;
                })
        }
    }
}
</script>

<style>

</style>