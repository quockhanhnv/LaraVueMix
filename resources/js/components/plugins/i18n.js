import Vue from 'vue'
import VueI18n from 'vue-i18n'
import en from '../langs/en.json'
import vn from '../langs/vn.json'
import jp from '../langs/jp.json'

Vue.use(VueI18n)

export const i18n = new VueI18n({
    locale: 'en',
    fallbackLocale: 'vn',
    messages: {
        en,
        vn,
        jp
    }
})
