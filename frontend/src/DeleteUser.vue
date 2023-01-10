<template>
    <div>
        <div style="border: black 1px solid; background-color: lightyellow">{{ result }}</div>
        <hr />
        <b>Delete</b><br />
        (* means required field)<br />
        <label for="email">* Email: </label>
        <input type="text" id="email" name="email" v-model="email"><br />
        <button @click="del()">Delete</button>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            result: null,
            email: null,
        }
    },
    methods: {
        del() {
            this.result = null;
            const data = {
                data: {
                    email: this.email
                }
            };
            axios.delete('http://localhost:2023/api/user', data,)
                .then((res) => {
                    this.result = res.data;
                })
        }
    }
}
</script>

<style>

</style>