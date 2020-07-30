<template>
    <div class="wrapper super-wrapper">
        <div class="bg">
            <div class="image-container" ref="container" @mousedown="moving">
                <img :src="src" alt="">
                <div @mousedown="resizing" class="controll se"></div>
                <div @mousedown="resizing" class="controll sw"></div>
                <div @mousedown="resizing" class="controll ne"></div>
                <div @mousedown="resizing" class="controll nw"></div>
            </div>
            <button @click="crop">обрезать</button>
        </div>
        <div class="overlay" ref="overlay"></div>
    </div>
</template>

<script>
    export default {
        name: "Cropper",
        data() {
            return {
                src: '',
                isResizing: false,
                mouse: {}
            }
        },
        props: {
            image: String,
            changeImage: Function
        },
        methods: {
            moving(e) {
                e.preventDefault()
                e.stopPropagation()

                const container = this.$refs.container

                this.mouse.x = e.clientX
                this.mouse.y = e.clientY

                const startMoving = e => {
                    if (!this.isResizing) {
                        let newX = this.mouse.x - e.clientX
                        let newY = this.mouse.y - e.clientY

                        const rect = container.getBoundingClientRect()

                        container.style.left = rect.left - newX + 'px'
                        container.style.top = rect.top - newY + 'px'

                        this.mouse.x = e.clientX
                        this.mouse.y = e.clientY
                    }
                }

                const stopMoving = e => {
                    window.removeEventListener('mousemove', startMoving)
                    window.removeEventListener('mouseup', stopMoving)
                }

                window.addEventListener('mousemove', startMoving)
                window.addEventListener('mouseup', stopMoving)
            },
            resizing(e) {
                e.preventDefault()
                e.stopPropagation()

                const currentStyle = e.target.classList[1]
                const container = this.$refs.container

                this.mouse.x = e.clientX
                this.mouse.y = e.clientY

                this.isResizing = true

                const startResizing = e => {
                    const copyImg = new Image()
                    const rect = container.getBoundingClientRect()

                    let width, height, top, left
                    copyImg.src = this.image // from props

                    switch(currentStyle) {
                        case 'se':
                            width = rect.width - (this.mouse.x - e.clientX)
                            height = rect.height - (this.mouse.y - e.clientY)
                            left = rect.left
                            top = rect.top
                            break
                        case 'sw':
                            width = rect.width + (this.mouse.x - e.clientX)
                            height = rect.height - (this.mouse.y - e.clientY)
                            left = rect.left - (this.mouse.x - e.clientX)
                            top = rect.top
                            break
                        case 'ne':
                            width = rect.width - (this.mouse.x - e.clientX)
                            height = rect.height + (this.mouse.y - e.clientY)
                            top = rect.top - (this.mouse.y - e.clientY)
                            left = rect.left
                            break
                        case 'nw':
                            width = rect.width + (this.mouse.x - e.clientX)
                            height = rect.height + (this.mouse.y - e.clientY)
                            top = rect.top - (this.mouse.y - e.clientY)
                            left = rect.left - (this.mouse.x - e.clientX)
                    }

                    container.style.width = width + 'px'
                    container.style.height = height + 'px'
                    container.style.top = top + 'px'
                    container.style.left = left + 'px'

                    this.mouse.x = e.clientX
                    this.mouse.y = e.clientY

                    this.drawImage(width, height, copyImg)
                }

                const stopResizing = e => {
                    window.removeEventListener('mousemove', startResizing)
                    window.removeEventListener('mouseup', stopResizing)
                    this.isResizing = false
                }

                window.addEventListener('mousemove', startResizing)
                window.addEventListener('mouseup', stopResizing)
            },
            drawImage(width, height, img) {
                const canvas = document.createElement('canvas')
                canvas.width = width
                canvas.height = height

                canvas.getContext('2d').drawImage(img, 0, 0, width, height)
                this.src = canvas.toDataURL('image/png')
            },
            crop() {
                const overlay = this.$refs.overlay
                const container = this.$refs.container
                const left = overlay.offsetLeft - container.offsetLeft
                const top = overlay.offsetTop - container.offsetTop
                const width = overlay.getBoundingClientRect().width
                const height = overlay.getBoundingClientRect().height
                const canvas = document.createElement('canvas')
                const copyImg = new Image()

                copyImg.src = this.src
                canvas.width = width
                canvas.height = height

                canvas.getContext('2d').drawImage(copyImg, left, top, width, height, 0, 0, width, height)

                this.changeImage(canvas.toDataURL('image/jpg'))
            }
        },
        created() {
            this.src = this.image
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

    .bg {
        width: 40vw;
        height: 500px;
        background: #fff;
        display: flex;
        align-items: flex-end;
        justify-content: center;
    }

    .image-container {
        position: absolute;
        width: 20%;
        height: 170px;
        top: calc(50% - 10%);
        left: calc(50% - 10%);
    }

    img {
        cursor: move;
        width: 100%;
        height: 100%;
    }

    .overlay {
        position: absolute;
        width: 200px;
        height: 200px;
        top: calc(50% - 100px);
        left: calc(50% - 100px);
        border: 2px solid #4eb543;
        z-index: 999;
        pointer-events: none;
    }

    .controll {
        position: absolute;
        width: 10px;
        height: 10px;
        background: #4eb543;
        borde-radius: 2px;
        z-index: 999;
    }

    .se {
        bottom: -5px;
        right: -5px;
        cursor: se-resize;
    }

    .sw {
        bottom: -5px;
        left: -5px;
        cursor: sw-resize;
    }

    .ne {
        top: -5px;
        right: -5px;
        cursor: ne-resize;
    }

    .nw {
        top: -5px;
        left: -5px;
        cursor: nw-resize;
    }

    button {
        margin-bottom: 15px;
        width: 120px;
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
</style>
