<template>
    <div>
        <div style="border: black 1px solid; background-color: lightyellow">{{ result }}</div>
        <hr />
        <b>Update</b><br />
        (* means required field)<br />
        <label for="email">* Current Email: </label>
        <input type="text" id="email" name="email" v-model="email"><br />
        <hr />
        <label for="name">Name: </label>
        <input type="text" id="name" name="name" v-model="name"><br />
        <label for="phone">Phone: </label>
        <input type="text" id="phone" name="phone" v-model="phone"><br />
        <label for="newEmail">New Email: </label>
        <input type="text" id="newEmail" name="newEmail" v-model="newEmail"><br />
        <label for="password">Password: </label>
        <input :type="passwordType" id="password" name="password" v-model="password"><br />
        <input type="checkbox" @click="showPassword()" />
        <span>Show Password</span>
        <br />
        <label for="username">Username: </label>
        <input type="text" id="username" name="username" v-model="username"><br />
        <label for="company">Company: </label>
        <input type="text" id="company" name="company" v-model="company"><br />
        <label for="nationality">Nationality: </label>
        <input type="text" id="nationality" name="nationality" v-model="nationality"><br />
        <br />
        <button @click="update()">Update</button>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            result: null,
            email: null,
            name: null,
            phone: null,
            newEmail: null,
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
        update() {
            this.result = null;
            const data = {
                email: this.email
            };
            if (this.name) data.name = this.name;
            if (this.phone) data.phone = this.phone;
            if (this.newEmail) data.newEmail = this.newEmail;
            if (this.password) data.password = this.password;
            if (this.username) data.username = this.username;
            if (this.company) data.company = this.company;
            if (this.nationality) data.nationality = this.nationality;
            axios.put('http://localhost:2023/api/user', data,)
                .then((res) => {
                    this.result = res.data;
                })
        }
    }
}
</script>

<style>

</style>