<template>
    <div class="admin" v-if="loaded">
        <AdminNav :presentUser="user" />
        <div class="templates-wrapper">
            <TemplatesNav />
            <div class="new-template">
                <div class="container">
                    <form action="create-template" enctype="multipart/form-data" method="post">
                        <input type="hidden" name="_token" :value="csrfToken">
                        <label for="template">Выберите шаблон</label>
                        <input type="hidden" name="id" value="">
                        <input name="template" required accept="text/html" type="file" id="template">
                        <button type="submit">Загрузить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from '../../../axios'

    import TemplatesNav from './TemplatesNav'
    import AdminNav from "../AdminNav";
    import Application from "../Application";

    export default {
        name: "Admin",
        data() {
            return {
                loaded: false,
                user: {},
                template: null,
                csrfToken: window.Laravel.csrfToken
            }
        },
        components: {
            AdminNav,
            Application,
            TemplatesNav,
        },
        created() {
            axios.get('login-check').then(() => { this.loaded = true })
            axios.get('get-user').then(res => this.user = res.data)
        }
    }
</script>

<style scoped>
    .new-template .container {
        height: 500px;
        display: grid;
        place-content: center;
    }

    .new-template form {
        display: flex;
        flex-direction: column;
    }

    .new-template label {
        width: 300px;
        height: 300px;
        background: #3820E9;
        color: #fff;
        font-size: 30px;
        font-weight: bold;
        display: grid;
        place-content: center;
        text-align: center;
        cursor: pointer;
    }

    .new-template input {
        pointer-events: none;
        opacity: 0;
        position: relative;
        top: -30px;
    }

    .new-template button {
        align-self: flex-end;
        background: #4eb543;
        border: 0;
        width: 100%;
        padding: 15px 8px;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        color: #fff;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .new-template button:focus {
        outline: none;
    }

    .new-template button:hover {
        background-color: #dc494c;
    }

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
