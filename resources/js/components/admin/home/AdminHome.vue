<template>
    <div class="admin" v-if="loaded">
        <AdminNav :presentUser="user" />
        <div>
            <Filters :sortApplications="sortApplications" v-if="user.role === 'admin'" />
            <Table :requestApplications="requestApplications" :applications="applications" v-if="user.role === 'admin'" />
            <Applications v-else-if="user.role === 'operator'" />
        </div>
    </div>
</template>

<script>
    import axios from '../../../axios'

    import AdminNav from "../AdminNav";
    import Filters from './Filters'
    import Table from './table/Table'
    import Applications from './Applications'

    export default {
        name: "Admin",
        data() {
            return {
                loaded: false,
                applications: [],
                user: {}
            }
        },
        components: {
            AdminNav,
            Filters,
            Table,
            Applications,
        },
        methods: {
            sortApplications(status) {
                axios.post('sort', { status: status })
                    .then(res => this.applications = res.data)
            },
            requestApplications() {
                axios.get('get-applications').then(res => this.applications = res.data)
            }
        },
        created() {
            axios.get('login-check').then(() => { this.loaded = true })
            axios.get('get-user').then(res => this.user = res.data)
        }
    }
</script>

<style scoped>
    .admin {
        padding-top: 15px;
        min-height: 100vh;
        background: #957fef;
    }

    .container-flex {
        justify-content: flex-start;
        flex-wrap: wrap;
    }
</style>

