<template>
    <div class="container">
        <header>
            <h1>Админ-панель</h1>
            <div v-if="presentUser.role === 'admin'" class="divider" />
            <div v-if="presentUser.role === 'admin'" class="links">
                <a v-for="(link, i) in links" :key="i" :href="link.path">{{link.text}}</a>
            </div>
        </header>
    </div>
</template>

<script>
    export default {
        name: "AdminNav",
        props: {
            presentUser: Object
        },
        data() {
            return {
                links: [
                    {
                        text: 'заявки',
                        path: '/admin/home'
                    },
                    {
                        text: 'шаблоны',
                        path: '/admin/templates'
                    }
                ],
                user: {}
            }
        },
    }
</script>

<style scoped>
    header {
        border-bottom: 2px solid #e1b7a3;
        margin: 0 0 15px 20px;
        padding-bottom: 8px;
        color: #fff;
        display: flex;
        align-items: center;
    }

    h1 {
        font-size: 45px;
    }

    .divider {
        height: 50px;
        width: 4px;
        background: #e1b7a3;
        margin: 0 10px;
    }

    .links {
        display: flex;
        align-items: center;
    }

    .links a {
        color: #fff;
        text-decoration: none;
        margin: 0 5px;
        cursor: pointer;
        background: #b168de;
        font-size: 14px;
        padding: 5px 10px;
        border-radius: 5px;
        box-shadow: 0 1px 5px rgba(255, 255, 255, 0.1);
    }
</style>
