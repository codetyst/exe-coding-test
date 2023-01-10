<template>
    <div>
        <b>List User</b><br />
        <div class="overflow-auto">
            <div style="display: flex">
                Keywords Filter: <b-input v-model="filter" placeholder="Filter table.."></b-input>
            </div>
            <b-table id="my-table" :fields="fields" :items="result" :per-page="perPage" :current-page="currentPage"
                :filter="filter" @filtered="onFiltered" small>
                <!-- A virtual column -->
                <template #cell(index)="data">
                    {{ data.index + 1 + (currentPage - 1) * 10 }}
                </template>

            </b-table>
            <b-pagination v-model="currentPage" :total-rows="rows" :per-page="perPage"
                aria-controls="my-table"></b-pagination>
            <p class="mt-3">Current Page: {{ currentPage }}</p>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            result: null,
            perPage: 10,
            currentPage: 1,
            rows: 0,
            filter: '',
            fields: [
                { key: 'index', label: '#' },
                { key: 'name', label: 'name' },
                { key: 'phone', label: 'phone' },
                { key: 'email', label: 'email' },
                { key: 'password', label: 'password' },
                { key: 'username', label: 'username' },
                { key: 'company', label: 'company' },
                { key: 'nationality', label: 'nationality' },
            ],
        }
    },
    created() {
        this.fetch();
    },
    methods: {
        fetch() {
            this.result = null;
            axios.get('http://localhost:2023/api/user')
                .then((res) => {
                    this.result = res.data;
                    this.rows = this.result.length;
                })
        },
        onFiltered(filteredItems) {
            this.rows = filteredItems.length
            this.currentPage = 1
            this.result.count = filteredItems.length
        }
    }
}
</script>

<style>

</style>