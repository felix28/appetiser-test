require('./bootstrap');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('calendar-component', require('./components/CalendarComponent.vue').default);

const app = new Vue({
    el: '#app'
});
