<template>
    <div class="row" >
        <div class="field name">{{application.name}}</div>
        <div class="field email">{{application.email}}</div>
        <div class="field type">
            <span>{{type(application.type)}}</span>
            <span class="purpose" @click="showPurposeText(application.purpose_of_visit)" v-if="application.type === 'temporary'">Цель посещения</span>
        </div>
        <div class="field status" :class="setStatusClass(application.status)">{{status(application.status)}}</div>
        <div class="field start-date">{{application.start_date ? getDate(application.start_date) : '-'}}</div>
        <div class="field end-date">{{application.end_date ? getDate(application.end_date) : '-'}}</div>
        <div @click="showPhoto(application.path)" class="field photo">
            <ShowPhoto />
        </div>
        <div class="field empty">
            <!--            <button-->
            <!--                @click="decline(application.id)"-->
            <!--                class="decline action-btn"-->
            <!--                :disabled="application.status === 'declined' ? true : false"-->
            <!--            >Отклонить</button>-->
            <button
                @click="declineClick()"
                class="decline action-btn"
            >Отклонить</button>
        </div>
        <div class="field empty">
            <!--            <button -->
            <!--                    @click="accept(application.id)" -->
            <!--                class="accept action-btn" -->
            <!--                :disabled="application.status === 'accepted' ? true : false" -->
            <!--            >Принять</button>-->
            <button
                @click="accept(application.id)"
                class="accept action-btn"
            >Принять</button>
        </div>
        <!-- MODALS -->
        <div v-if="showPhotoModal" class="wrapper">
            <img :src="src" alt="">
            <div class="close-btn" @click="closePhoto()">Закрыть</div>
        </div>
        <div v-if="showPurpose" class="wrapper">
            <div class="content">{{purpose}}</div>
            <div class="close-btn" @click="closePurposeText()">Закрыть</div>
        </div>
        <div v-if="showDeclineModal" class="wrapper">
            <div class="content">
                <h3>Введите причину отклонения</h3>
                <form @submit.prevent="decline(application.id)">
                    <textarea required placeholder="..."  v-model="declineReason"/>
                    <button class="decline-btn" type="submit">Отклонить</button>
                </form>
            </div>
            <div class="close-btn" @click="closeDeclineForm()">Закрыть</div>
        </div>
        <!-- MODALS END -->
    </div>
</template>

<script>
    import axios from '../../../../axios'
    import ShowPhoto from './ShowPhoto'

    export default {
        name: "Row",
        props: {
            requestApplications: Function
        },
        data() {
            return {
                src: '',
                purpose: '',
                declineReason: '',
                showPhotoModal: false,
                showPurpose: false,
                showDeclineModal: false
            }
        },
        components: {
            ShowPhoto,
        },
        props: {
            application: Object,
            requestApplications: Function
        },
        methods: {
            declineApplication(params) {
                return axios.post('decline', { id: params.id, declineReason: params.declineReason })
            },
            acceptApplication(id) {
                return axios.post('accept', { id: id })
            },
            declineClick() {
                this.showDeclineModal = true
            },
            closeDeclineForm() {
                this.showDeclineModal = false
            },
            decline(id) {
                this.declineApplication({id: id, declineReason: this.declineReason})
                    .then(() => {
                        this.requestApplications()
                        this.closeDeclineForm()
                    })
            },
            accept(id) {
                this.acceptApplication(id)
                    .then(() => this.requestApplications())
            },
            closePhoto() {
                this.showPhotoModal = false
                document.querySelector('body').style.overflow = 'visible'
            },
            showPhoto(src) {
                this.src = src
                this.showPhotoModal = true
                document.querySelector('body').style.overflow = 'hidden'
            },
            showPurposeText(purpose) {
                this.purpose = purpose
                this.showPurpose = true
                document.querySelector('body').style.overflow = 'hidden'
            },
            closePurposeText() {
                this.showPurpose = false
                document.querySelector('body').style.overflow = 'visible'
            },
            type(type) {
                switch(type) {
                    case 'constant':
                        return 'Постоянный'
                        break
                    case 'temporary':
                        return 'Временный'
                        break
                }
            },
            status(status) {
                switch (status) {
                    case 'waiting':
                        return 'Рассматривается'
                        break
                    case 'accepted':
                        return 'Принята'
                        break
                    case 'declined':
                        return 'Отклонена'
                        break
                    case 'ready':
                        return 'Распечатана'
                        break
                }
            },
            getDate(date) {
                const months = ["01", "02", "03","04", "05", "06", "07", "08", "09", "10", "11", "12"]
                const time = new Date(date)

                return time.getDate() + '.' + months[time.getMonth()] + '.' + time.getFullYear()
            },
            setStatusClass(status) {
                switch(status) {
                    case 'waiting':
                        return ''
                        break
                    case 'accepted':
                        return 'green'
                        break
                    case 'declined':
                        return 'red'
                        break
                    case 'ready':
                        return 'blue'
                }
            }
        }
    }
</script>

<style scoped>
    .wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: rgba(0, 0, 0, 0.5);
        display: grid;
        place-content: center;
        z-index: 100;
    }

    .wrapper .content {
        padding: 40px;
        background: #fff;
        text-align: justify;
        border-radius: 4px;
        width: 40vw;
    }

    .wrapper .close-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        color: #fff;
        font-weight: bold;
        font-size: 15px;
        cursor: pointer;
    }

    .wrapper textarea {
        margin: 15px 0;
        padding: 5px 10px;
        font-size: 14px;
        background-color: transparent;
        border: 1px solid rgba(0, 0, 0, 0.5);
        color: #000;
        resize: none;
        height: 100px;
        width: 100%;
        display: block;
    }

    .wrapper textarea:focus {
        outline: none;
    }

    .wrapper h3 {
        font-size: 28px;
    }

    .wrapper .decline-btn {
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

    .green {
        color: #4eb543;
    }

    .red {
        color: crimson;
    }

    .blue {
        color: #3820E9;
    }

    .purpose {
        background: #5838e5;
        font-size: 12px;
        margin-top: 3px;
    }

    .action-btn, .purpose {
        border: 0;
        padding: 7px 2px;
        cursor: pointer;
        border-radius: 3px;
        color: #fff;
        font-weight: bold;
    }

    .accept {
        background: #cdc7f9;
    }

    .decline {
        background: #f2f2f2;
        color: #000;
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
        white-space: nowrap;
        overflow: hidden;
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
        display: grid;
        place-content: center;
    }

    .empty {
        flex: 0 0 6%;
    }

    button:focus {
        outline: 0;
    }
</style>
