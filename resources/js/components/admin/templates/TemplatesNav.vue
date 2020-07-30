<template>
    <div class="nav">
        <div class="container container-flex">
            <div v-for="(el, i) in navElements" :key="i">
                <a
                    :href="el.path"
                    class="nav-item"
                    :class="el.isSelected ? 'selected' : ''"
                    @click="focusEl(i)"
                >
                    <p>{{el.text}}</p>
                    <div class="line" :class="el.lineClass"></div>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TemplatesNav",
        data() {
            return {
                navElements: [
                    {
                        text: 'Шаблоны',
                        lineClass: 'line-one',
                        path: '/admin/templates',
                        isSelected: true
                    },
                    {
                        text: 'Добавить шаблон',
                        lineClass: 'line-two',
                        path: '/admin/new-template',
                        isSelected: false
                    },
                ]
            }
        },
        methods: {
            focusEl(i) {
                this.navElements = this.navElements.map(el => {
                    return {...el, isSelected: false}
                })

                this.navElements[i].isSelected = true
            }
        }
    }
</script>

<style scoped>
    .nav {
        padding: 70px 0;
        background: #957fef;
    }

    .container-flex {
        justify-content: center;
    }

    .nav-item {
        margin: 0 25px;
        width: 300px;
        height: 140px;
        background: #fff;
        border-radius: 4px;
        cursor: pointer;
        display: grid;
        place-content: center;
        font-weight: bold;
        text-transform: capitalize;
        box-shadow: 0 3px 14px rgba(0, 0, 0, 0.4);
        font-size: 20px;
        text-align: center;
        transition: all 0.2s ease;
    }

    .line {
        width: 150px;
        height: 4px;
        margin: 10px auto;
    }

    .line-one {
        background: #E6C3B2;
    }

    .line-two {
        background: #dec0f1;
    }

    .selected {
        box-shadow: 0 3px 18px rgba(0, 0, 0, 0.6);
        border: 4px solid #d2c9f8;
    }

    a {
        color: #000;
        text-decoration: none;
    }
</style>
