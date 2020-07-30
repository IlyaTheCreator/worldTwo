<template>
    <div class="wrapper">
        <div class="container">
            <h1>Превью одобренных пропусков</h1>
            <div class="applications">
                <div
                    class="application"
                    v-for="(application, i) in applications"
                    :key="i"
                >
                    <Application
                        :name="application.name"
                        :email="application.email"
                        :iframeSrc="application.template"
                        :imageSrc="application.path"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "../../../axios";
    import Application from "../Application";

    export default {
        name: "Applications",
        components: {
            Application
        },
        data() {
            return {
                applications: [],
            }
        },
        created() {
            axios.get('get-applications')
                .then(res => {
                    this.applications = res.data
                })
        }
    }
</script>

<style scoped>
    .wrapper {
        min-height: 100vh;
        background: #fff;
        padding-top: 35px;
    }

    .applications {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .application {
        cursor: pointer;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        margin: 10px 6px;
        width: 400px;
    }
</style>
