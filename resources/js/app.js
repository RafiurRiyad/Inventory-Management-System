require('./bootstrap');

window.Vue = require('vue').default;
import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

//Route imported
import {routes} from './routes';

//import User class
import User from './helpers/User';
window.User = User;

//import Notification class
import Notification from './helpers/Notification';
window.Notification = Notification;

// sweet alert start
import Swal from 'sweetalert2';
window.Swal = Swal;

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})
window.Toast = Toast;
//sweet alert end

const router = new VueRouter({
    routes,
    mode:'history',
  })

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    router
});
