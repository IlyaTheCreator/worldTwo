import axios from './axios'

export default {
    changeBodyOverflow(param) {
        if (param) {
            document.querySelector('body').style.overflow = 'hidden'
        } else {
            document.querySelector('body').style.overflow = 'visible'
        }
    },
    getUser() {
        return axios.get('get-user')
    }
}
