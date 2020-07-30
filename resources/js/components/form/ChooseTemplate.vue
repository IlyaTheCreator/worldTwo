<template>
    <div class="wrapper">
        <div class="content">
            <h1>Шаблоны:  <div class="buttons"><button @click="submit">Отправить</button> <button @click="submit">Отправить без шаблона</button></div>
            </h1>
            <div class="templates">
                <div
                    class="template"
                    :class="template.clicked ? 'border' : ''"
                    v-for="(template, i) in templates"
                    :key="i"
                    @click="click(template.path, i)"
                >
                    <Application
                        :name="name"
                        :email="email"
                        :iframeSrc="template.path"
                        :imageSrc="image"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from '../../axios'
    import Application from '../admin/Application'

    export default {
        name: "ChooseTemplate",
        components: {
            Application,
        },
        props: {
            setTemplate: Function,
            submitData: Function
        },
        data() {
            return {
                templates: [],
                template: '',
                name: 'Имя',
                email: 'mail@mail.com',
                image: window.Laravel.baseURL + '/uploads/images/no-avatar.jfif',
            }
        },
        methods: {
            click(path, i) {
                this.template = path
                this.setTemplate(path)

                this.templates = this.templates.map(template => {
                    return {...template, clicked: false}
                })

                this.templates[i].clicked = true
            },
            submit() {
                this.submitData()
            }
        },
        created() {
            axios.get('get-templates')
                .then(res => this.templates = res.data.map(template => {
                    return {...template, clicked: false}
                }))
        }
    }
</script>

<style scoped>
    .wrapper {
        position: absolute;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.5);
        display: grid;
        place-content: center;
        z-index: 100;
    }

    h1 {
        font-size: 40px;
        margin-bottom: 20px;
        padding: 10px;
        display: flex;
        justify-content: space-between;
    }

    .content {
        width: 70vw;
        height: 700px;
        background: #fff;
        color: #000;
        padding: 30px;
        overflow-y: scroll;
    }

    .templates {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .template {
        cursor: pointer;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        margin: 10px 6px;
        width: 400px;
    }

    .responsive-container {
        width: 400px;
        pointer-events: none;
    }

    iframe {
        pointer-events: none;
    }

    .border {
        border: 3px solid #4eb543;
        border-radius: 10px;
    }

    button {
        align-self: flex-end;
        background-color: #4eb543;
        border: 0;
        max-width: 270px;
        padding: 15px 8px;
        font-size: 16px;
        text-align: center;
        color: #fff;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    button:focus {
        outline: none;
    }

    button:hover {
        background: rgba(75, 170, 64, 0.97);
    }
</style>
