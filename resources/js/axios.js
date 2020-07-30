import axios from 'axios'

const customAxios = axios.create({
    baseURL: window.Laravel.baseURL
})

customAxios.defaults.headers = {
    'x-csrf-token': window.Laravel.csrfToken,
    'x-requested-with': 'XMLHttpRequest',
}

export default customAxios
