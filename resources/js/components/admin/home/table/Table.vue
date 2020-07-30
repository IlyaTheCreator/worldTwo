<template>
    <div class="wrapper">
        <div class="container">
            <div class="table">
                <div class="row table-header">
                    <div class="field name">Имя</div>
                    <div class="field email">Почта</div>
                    <div class="field type">Тип</div>
                    <div class="field status">Статус</div>
                    <div class="field start-date">Начало действия</div>
                    <div class="field end-date">Окончание действия</div>
                    <div class="field photo">Фото</div>
                    <div class="field empty"></div>
                    <div class="field empty"></div>
                </div>
                <Row :requestApplications="requestApplications" v-for="(application, i) in applications" :key="i" :application="application" />
            </div>
        </div>
    </div>
</template>

<script>
    import Row from './Row'

    export default {
        name: "Table",
        props: {
            requestApplications: Function,
            applications: Array
        },
        components: {
            Row,
        },
        created() {
            this.requestApplications()
        }
    }
</script>

<style scoped>
    .wrapper {
        background: #fff;
        height: 80vh;
        display: flex;
        justify-content: center;
        padding: 50px 0;
    }

    .table {
        width: 75vw;
        min-height: 100px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.15);
        border-radius: 3px;
    }

    .table-header {
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
        background: #f5e6e0;
    }

    .table-header .field {
        font-weight: bold;
        border: 0;
    }

    .row {
        display: flex;
        border-bottom: 1px solid #ccc;
    }

    .field:last-child {
        border-right: 0;
    }

    .field {
        padding: 10px;
        text-align: center;
        display: grid;
        place-content: center;
        border-right: 1px solid #ccc;
    }

    .name {
        flex: 0 0 17%;
    }

    .email {
        flex: 0 0 17%;
    }

    .type {
        flex: 0 0 13%;
    }

    .status {
        flex: 0 0 12.5%;
    }

    .start-date {
        flex: 0 0 10%;
    }

    .end-date {
        flex: 0 0 10%;
    }

    .photo {
        flex: 0 0 7.5%;
    }

    .empty {
        flex: 0 0 6%;
    }
</style>
