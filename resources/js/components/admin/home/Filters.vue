<template>
    <div class="filters">
        <div class="container container-flex">
            <div
                v-for="(filter, i) in filters"
                :key="i"
                class="filter"
                :class="filter.isSelected ? 'selected' : ''"
                @click="sort(filter.sortStatus, i)"
            >
                <p>{{filter.text}}</p>
                <div class="line" :class="filter.lineClass"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Filters",
        props: {
            sortApplications: Function
        },
        data() {
            return {
                filters: [
                    {
                        text: 'Все заявки',
                        lineClass: 'line-one',
                        sortStatus: 'all',
                        isSelected: true
                    },
                    {
                        text: 'заявки к рассмотрению',
                        lineClass: 'line-two',
                        sortStatus: 'waiting',
                        isSelected: false
                    },
                    {
                        text: 'принятые заявки',
                        lineClass: 'line-three',
                        sortStatus: 'accepted',
                        isSelected: false
                    },
                    {
                        text: 'Отклоненные заявки',
                        lineClass: 'line-four',
                        sortStatus: 'declined',
                        isSelected: false
                    },
                    {
                        text: 'Распечатанные заявки',
                        lineClass: 'line-five',
                        sortStatus: 'ready',
                        isSelected: false
                    }
                ],
            }
        },
        methods: {
            sort(status, i) {
                this.filters = this.filters.map(filter => {
                    return {...filter, isSelected: false}
                })

                this.filters[i].isSelected = true
                this.sortApplications(status)
            }
        },
    }
</script>

<style scoped>
    .filters {
        padding: 70px 0;
        background: #957fef;
    }

    .filter {
        width: 250px;
        height: 140px;
        background: #fff;
        border-radius: 4px;
        cursor: pointer;
        display: grid;
        place-content: center;
        font-weight: bold;
        text-transform: uppercase;
        box-shadow: 0 3px 14px rgba(0, 0, 0, 0.4);
        font-size: 16px;
        text-align: center;
        transition: all 0.2s ease;
        padding: 10px;
    }

    .selected {
        box-shadow: 0 3px 18px rgba(0, 0, 0, 0.6);
        border: 4px solid #d2c9f8;
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

    .line-three {
        background: #3820E9;
    }

    .line-four {
        background: #b168de;
    }

    .line-five {
        background: #5838e5;
    }
</style>
