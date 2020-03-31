window.Vue = require('vue');

//do not show console log developement tool
Vue.config.devtools = false;
//do not show console log of production mode
Vue.config.productionTip = false;

window.axios = require('axios');
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest'
};

import Echo from 'laravel-echo';
window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});

//Vue.component('favorite', require('./components/Favorite.vue'));
//Vue.component('publish', require('./components/Publish.vue'));
Vue.component('chat-app', require('./components/ChatApp.vue'));

window.Event = new Vue();

var ModalComponent = Vue.component('modal', {
  template: '#detail-modal-template',
  props: ['show'],
  data(){
    return {
      modal: {
        title: 'Loading...',
        body: 'Please wait for a minute!',
      }
    };
  },
  methods: {
    closeModal: function () {
      this.$emit('close');
      this.modal = {
        title: 'Loading...',
        body: 'Please wait for a minute!',
      }
    }
  },
  created() {
    Event.$on('toggleModal', (row) => {
      var _data = {
        title: row.title,
        body: row.template
      }
      this.modal = _data;
      setTimeout(function(){
        videojs(document.getElementById('watch-video'), {}, function() {
            // This is functionally the same as the previous example.
        });
      },300);
    });
  }
});


const app = new Vue({
    el: '#app',
    data: {
      showModal: false,
      detail: {}
    },
    methods:{
      watchVideo: function (url_video,date_create) {
        this.showModal = true;
        var _html = '<video id="watch-video" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" height="100%" width="100%">';
        _html += '<source src="'+url_video+'" type="video/mp4" />';
        _html += '</video>';
        Event.$emit('toggleModal', {'template':_html,'title':date_create});
      }
    }
});