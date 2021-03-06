
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('chat', require('./components/ChatComponent.vue').default);
Vue.component('notify', require('./components/NotifyComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    created: function () {
        let auth_id = document.head.querySelector('meta[name="auth_id"]').content;
        window.auth_id =auth_id;
        // window.Echo.channel('question-channel.1')
        //     .listen('.question_event', (e) => {
        //         console.log(e);
        // });
        window.Echo.channel('post-channel.1')
            .listen('.post_event', (e) => {
                console.log(e);
        });
        // window.Echo.channel('comment-channel.9')
        //     .listen('.comment_event', (e) => {
        //         console.log(e);
        // });
        // window.Echo.channel('chat-channel.4')
        //     .listen('.chat_event', (e) => {
        //         console.log(e);
        // });
        // window.Echo.channel('notify-channel.11')
        //     .listen('.notify_event', (e) => {
        //         console.log(e);
        // });
        // window.Echo.channel('notify-channel.1')
        //     .listen('.notify_event', (e) => {
        //         console.log(e);
        // // });
        // window.Echo.channel('poll-channel.1')
        //     .listen('.poll_event', (e) => {
        //         console.log(e);
        // });
        window.Echo.channel('vote-channel.9')
            .listen('.vote_event', (e) => {
                console.log(e);
        });
    }
});

