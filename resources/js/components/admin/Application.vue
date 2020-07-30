<template>
    <div class="responsive-container">
        <iframe @load="load" :src="iframeSrc" frameborder="0" />
    </div>
</template>

<script>

    export default {
        name: "Application",
        props: {
            iframeSrc: String,
            name: String,
            email: String,
            imageSrc: String
        },
        methods: {
            load(e) {
                const iframeDocument = e.target.contentDocument
                const nameEl = iframeDocument.getElementById('name')
                const emailEl = iframeDocument.getElementById('email')
                const imageEl = iframeDocument.getElementById('image')

                iframeDocument.querySelector('body').style.overflow = 'hidden'
                iframeDocument.querySelector('body').style.fontFamily = 'Montserrat, sans-serif'

                nameEl.innerText = this.name
                emailEl.innerText = this.email
                imageEl.src = this.imageSrc
            }
        },
        created() {
            console.log(this.iframeSrc)
        }
    }
</script>

<style scoped>
    .responsive-container {
        position: relative;
        overflow: hidden;
        /*padding-top: 56.25%;*/
        flex: 0 0 30%;
        height: 500px;
        margin: 10px;
        /*This is where the magic is. In CSS, the padding-top property can receive a percentage, this is what keeps our iframe to the right ratio. By using */
        /*percentage, it will calculate the padding to use based on the width of the element. In our example, we want to keep the ratio */
        /*of 56.26% (height 9 ÷ width 16) because this is the default ratio for YouTube videos. However, other ratios can be used as well.*/
    }

    iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }
</style>
