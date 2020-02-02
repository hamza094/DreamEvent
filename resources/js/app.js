/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window._= require("lodash");

window.Fire = new Vue();

import swal from 'sweetalert2'

window.swal=swal;

const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  //timer: 3000
});

/*import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';

document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

  var calendar = new Calendar(calendarEl, {
    plugins: [ dayGridPlugin ]
  });

  calendar.render();
});*/


swal.disableInput();

import VueRouter from 'vue-router'

Vue.use(VueRouter)

import moment from 'moment';

Vue.filter('timeDate',function(data){
   return  moment(data).format("MMM Do YYYY");  
})


import VueProgressBar from 'vue-progressbar';

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '3px'
})

import { Form, HasError, AlertError } from 'vform'

import VModal from 'vue-js-modal';

Vue.use(VModal)
 
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

window.Form=Form;



//window.toast=toast;


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('dropdown', require('./components/Dropdown.vue').default);
Vue.component('edit-profile', require('./components/EditProfile.vue').default);
Vue.component('avatar-form', require('./components/AvatarForm.vue').default);
Vue.component('recaptcha', require('./components/Recaptcha.vue').default);
Vue.component('searchform', require('./components/SearchForm.vue').default);
Vue.component('events', require('./components/Events.vue').default);
Vue.component('reply-form', require('./components/Reply-Form.vue').default);
Vue.component('reply', require('./components/Reply.vue').default);
Vue.component('subscribe', require('./components/Subscribe.vue').default);
Vue.component('ticket-form', require('./components/TicketForm.vue').default);
Vue.component('discussionreply', require('./components/DiscussionReply.vue').default);
Vue.component('contact-form', require('./components/ContactForm.vue').default);
Vue.component('event-follow', require('./components/EventFollow.vue').default);
Vue.component('event-option', require('./components/EventOption.vue').default);
Vue.component('notifications', require('./components/Notifications.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));




const routes = [
  { path: '/dashboard', component: require('./components/Dashboard.vue').default },
  { path: '/users', component: require('./components/Users.vue').default },
  { path: '/topics', component: require('./components/Topics.vue').default },
  { path: '*', component:require('./components/Error.vue').default}
]


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const router = new VueRouter({
    mode: 'history',
  routes // short for `routes: routes`
})

const app = new Vue({
    el: '#app',
     router
});

const nav= new Vue({
   el:'#nav',
    router
}); 
 

const show= new Vue({
   el:'#show',
    router
}); 