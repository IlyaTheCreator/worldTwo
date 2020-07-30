require('./bootstrap');

window.Vue = require('vue')

Vue.component('home-component', require('./components/Home').default)
Vue.component('form-component', require('./components/form/Form').default)
Vue.component('application-component', require('./components/admin/Application').default)
Vue.component('admin-login-component', require('./components/admin/Login').default)
Vue.component('admin-home-component', require('./components/admin/home/AdminHome').default)
Vue.component('admin-templates-component', require('./components/admin/templates/Templates').default)
Vue.component('new-template-component', require('./components/admin/templates/NewTemplate').default)

const app = new Vue({
    el: '#app'
})
