<template>
    <footer>
        <div class="container container-flex">
            <div class="col">
                <a href="#">lorem ipsum dolor set</a>
                <a href="#">lorem ipsum dolor set</a>
                <a href="#">lorem ipsum dolor set</a>
                <a href="#">lorem ipsum dolor set</a>
            </div>
            <div class="col">
                <a href="#">lorem ipsum dolor set</a>
                <a href="#">lorem ipsum dolor set</a>
                <a href="#">lorem ipsum dolor set</a>
                <a href="#">lorem ipsum dolor set</a>
            </div>
            <div class="col">
                <a href="#">lorem ipsum dolor set</a>
                <a href="#">lorem ipsum dolor set</a>
                <a href="#">lorem ipsum dolor set</a>
                <a href="#">lorem ipsum dolor set</a>
            </div>
            <div class="col contact">
                <p>Есть вопросы?</p>
                <span class="phone">7 000 000 00 00</span>
            </div>
        </div>
    </footer>
</template>

<script>
    export default {
        name: "Footer"
    }
</script>

<style scoped>
    footer {
        background: #2d2d44;
        color: #fff;
        padding: 50px 0;
    }

    .col {
        flex: 0 0 25%;
    }

    .contact {
        flex: 0 0 40%;
    }

    p, a {
        font-size: 15px;
        display: block;
        text-decoration: none;
        color: #fff;
    }

    .phone {
        display: block;
        font-weight: bold;
        margin-top: 5px;
    }
</style>
