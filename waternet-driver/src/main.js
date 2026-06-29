import dayjs from "dayjs";
import {createApp} from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import i18n from './plugins/i18n'

import './plugins'
import './bootstrap';


Number.prototype.format = function (n, x) {
    let re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};

const app = createApp(App)
    .use(store)
    .use(router)
    .use(i18n)
    .mixin({
        methods: {
            formatMoney(value) {
                value = Number(value) || 0;

                let $result = Math.abs(value).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                $result = $result.substring(0, $result.length - 3);
                if (value < 0) $result = `-${$result}`

                return $result;
            },

            pluck(array, key) {
                return array.map(o => o[key]);
            },

            formatDate(value) {
                if (value) {
                    return dayjs(String(value)).format('DD.MM.YYYY hh:mm')
                }
            }
        }
    })
    .mount('#app')