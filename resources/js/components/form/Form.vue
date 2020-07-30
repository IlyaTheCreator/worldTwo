<template>
    <div>
        <Cropper :image="imageBase64" v-if="showCropper" :changeImage="changeImage"/>
        <ChooseTemplate v-if="showChooseTemplate" :setTemplate="setTemplate" :submitData="submitData"/>

        <form class="apply-form" @submit.prevent="click">
            <div class="left">
                <div class="base64-wrapper" v-if="showCroppedImg">
                    <img :src="imageBase64"  alt="">
                </div>
                <div v-else>
                    <label for="image">Фото</label>
                    <input @change="imageChange"" id="image" required type="file">
                </div>
                <label v-if="showExtraFields" for="purposeOfVisit">Цель посещения:</label>
                <textarea
                    :required="showExtraFields ? true : false"
                    v-if="showExtraFields"
                    v-model="form.purposeOfVisit"
                    placeholder="Просто так"
                />
            </div>
            <div class="right">
                <label for="name">ФИО:</label>
                <input
                    id="name"
                    v-model="form.name"
                    type="text" accept="image/jpg,image/jpeg,image/png"
                    required
                    placeholder="Петров Петр Петрович"
                >
                <label for="email" type="email" required>Почта:</label>
                <input v-model="form.email" id="email" type="email" placeholder="mail@mail.com" required>
                <label for="type">Тип пропуска: </label>
                <select v-model="form.type" name="type" id="type">
                    <option selected value="temporary">Временный</option>
                    <option value="constant">Постоянный</option>
                </select>
                <label  v-if="showExtraFields" for="startDate">Дата начала действия пропуска:</label>
                <input :required="showExtraFields ? true : false" v-if="showExtraFields" v-model="form.startDate" type="date" id="startDate">
                <label  v-if="showExtraFields"  for="endDate">Дата окончания действия пропуска:</label>
                <input  :required="showExtraFields ? true : false" v-if="showExtraFields" v-model="form.endDate" type="date" id="endDate">
                <button type="submit">Перейти к выбору шаблона</button>
            </div>
        </form>
    </div>
</template>

<script>
    import Cropper from "./Cropper";
    import ChooseTemplate from './ChooseTemplate'

    export default {
        name: "Form",
        components: {
            Cropper,
            ChooseTemplate
        },
        data() {
            return {
                form: {
                    name: '',
                    email: '',
                    type: 'constant',
                    startDate: '',
                    endDate: '',
                    purposeOfVisit: '',
                    imageFile: null,
                    template: ''
                },
                showCropper: false,
                imageBase64: '',
                showCroppedImg: false,
                showChooseTemplate: false
            }
        },
        methods: {
            imageChange(e) {
                this.form.imageFile = e.target.files[0]
                this.showCropper = true
                document.querySelector('body').style.overflow = 'hidden'
                this.imageBase64 = URL.createObjectURL(this.form.imageFile)
            },
            changeImage(img) {
                this.imageBase64 = img
                this.showCropper = false
                this.showCroppedImg = true
                document.querySelector('body').style.overflow = 'visible'
            },
            setTemplate(template) {
                this.form.template = template
            },
            click() {
                document.querySelector('body').style.overflow = 'hidden'
                console.log(document.querySelector('body').style.overflow)
                this.showChooseTemplate = true
            },
            submitData() {
                const data = {
                    name: this.form.name,
                    email: this.form.email,
                    template: this.form.template,
                    image: this.imageBase64,
                    type: this.form.type,
                    startDate: this.form.startDate,
                    endDate: this.form.endDate,
                    purposeOfVisit: this.form.purposeOfVisit,
                }

                const headers = {
                    'x-csrf-token': window.Laravel.csrfToken
                }

                axios({
                    method: 'post',
                    url: 'apply',
                    data: data,
                    headers: headers
                })
                    .then(res => {
                        this.showChooseTemplate = false
                        document.querySelector('body').style.overflow = 'visible'
                        alert('Заявка успешно отправлена')

                        this.form.name = ''
                        this.form.email = ''
                        this.form.imageFile = null
                        this.imageBase64 = ''
                        this.showCroppedImg = false
                        this.form.template = ''
                        this.form.type = 'constant'
                        this.form.startDate = ''
                        this.form.endDate = ''
                        this.form.purposeOfVisit = ''
                    })
            },
        },
        computed: {
            showExtraFields() {
                if (this.form.type === 'temporary') {
                    return true
                } else {
                    return false
                }
            }
        }
    }
</script>

<style scoped>
    .apply-form {
        position: relative;
        display: flex;
        justify-content: space-between;
        background: rgba(255, 255, 255, 0.1);
        padding: 20px;
    }

    .left {
        flex: 0 0 49%;
        height: 100%;
        display: grid;
        place-content: center;
    }

    input[type="file"] {
        opacity: 0;
        position: absolute;
        top: 80px;
        pointer-events: none;
    }

    label[for="image"] {
        cursor: pointer;
        width: 300px;
        height: 300px;
        display: grid;
        place-content: center;
        background: #e6c3b2;
        font-weight: bold;
        font-size: 40px;
    }

    .right {
        flex: 0 0 49%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    label {
        font-weight: bold;
    }

    input, select, textarea {
        margin: 15px 0;
        height: 35px;
        padding: 5px 10px;
        font-size: 14px;
        color: #fff;
        background-color: transparent;
        border: 1px solid rgba(255, 255, 255, 0.5);
        color: #fff;
    }

    select > option{
        color: #000;
    }

    input::placeholder, select::placeholder, textarea::placeholder {
        color: #fff;
    }

    input:focus, select:focus, textarea:focus {
        outline: none;
    }

    label[for="purposeOfVisit"] {
        margin: 10px 0 1px 0;
    }

    textarea {
        resize: none;
        height: 100%;
        width: 300px;
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

    .base64-wrapper {
        width: 100%;
    }
</style>
