<template>
    <div class="admin" v-if="loaded">
        <AdminNav :presentUser="user" />
        <div class="templates-wrapper">
            <TemplatesNav />
            <div class="all-templates">
                <div class="container">
                    <div class="templates">
                        <div
                            class="template"
                            :class="template.clicked ? 'border' : ''"
                            v-for="(template, i) in templates"
                            :key="i"
                        >
                            <Application
                                :name="name"
                                :email="email"
                                :iframeSrc="template.path"
                                :imageSrc="image"
                            />
                            <div class="delete-template">
                                <button @click="deleteTemplate(template.id)">Удалить</button>
                            </div>
                        </div>
                    </div>
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
                templates: [],
                name: 'Имя',
                email: 'mail@mail.com',
                image: window.Laravel.baseURL + '/uploads/images/no-avatar.jfif',
            }
        },
        components: {
            AdminNav,
            Application,
            TemplatesNav,
        },
        methods: {
            getTemplates() {
                axios.get('get-templates')
                    .then(res => this.templates = res.data)
            },
            deleteTemplate(id) {
                axios.post('delete-template', { id: id })
                    .then(() => this.getTemplates())
            }
        },
        created() {
            axios.get('login-check').then(() => { this.loaded = true })
            axios.get('get-user').then(res => this.user = res.data)

            this.getTemplates()
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

    .templates-wrapper {
        background: #fff;
        min-height: 100vh;
    }

    .all-templates {
        padding-top: 35px;
    }

    .templates {
        display: flex;
        flex-wrap: wrap;
    }

    .template {
        width: 400px;
        cursor: pointer;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        margin: 10px 6px;
    }

    .delete-template button {
        align-self: flex-end;
        background-color: crimson;
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

    .delete-template button:focus {
        outline: none;
    }

    .delete-template button:hover {
        background-color: #dc494c;
    }
</style>

