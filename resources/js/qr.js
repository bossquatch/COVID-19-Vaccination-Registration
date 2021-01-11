import Vue from 'vue'

window.Vue = require('vue')

//Vue.use(VueQrcodeReader);

import QR from './QR.vue';

const app = new Vue({
    el: '#qr-reader-app',
    components: {
        QR
    },
    render: h => h(QR)
});