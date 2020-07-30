<template>
    <div class="admin">
        <div class="content">
            <h1>Вход в панель администратора</h1>
            <form action="admin-login" method="post">
                <input type="hidden" name="_token" :value="csrfToken">
                <label for="name">Имя</label>
                <input v-model="name" type="text" name="name" required id="name" placeholder="Имя">
                <label for="password">Пароль</label>
                <input v-model="password" type="password" name="password" required id="password" placeholder="Пароль">
                <button type="submit">Войти</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Login",
        data() {
            return {
                name: '',
                password: '',
                errors: [],
                csrfToken: window.Laravel.csrfToken
            }
        },
        methods: {
            submit() {
                this.errors = []

                if (!this.name) {
                    this.errors.push('Имя обязательно')
                }

                if (!this.password) {
                    this.errors.push('Пароль обязателен')
                }

                // if (!this.errors.length) {
                //     axios.post('admin-login', { name: this.name, password: this.password })
                //         .then(() => this.$router.push('/admin'))
                //         .catch(error => this.errors.push(error))
                // }
            }
        }
    }
</script>

<style scoped>
    .admin {
        width: 100%;
        height: 100vh;
        background: #3820E9;
        color: #fff;
        display: grid;
        place-content: center;
    }

    form {
        margin: 30px auto 0 auto;
        width: 550px;
        background: rgba(255, 255, 255, 0.1);
        padding: 30px;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    h1 {
        font-size: 40px;
    }

    label {
        font-weight: bold;
        margin: 10px 0 3px 0;
    }

    input {
        margin: 5px 0;
        height: 35px;
        padding: 5px 10px;
        font-size: 14px;
        color: #fff;
        background-color: transparent;
        border: 1px solid rgba(255, 255, 255, 0.5);
        color: #fff;
    }

    input::placeholder {
        color: #fff;
    }

    input:focus {
        outline: none;
    }

    button {
        align-self: center;
        width: 200px;
        margin-top: 20px;
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
