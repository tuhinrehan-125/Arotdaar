import Vue from 'vue';
import VueI18n from 'vue-i18n';

Vue.use (VueI18n)

export default ({app, store}) => {
  app.i18n = new VueI18n ({
    locale: localStorage.getItem("lang") || 'en',
    fallbackLocale: localStorage.getItem("lang") || 'en',
    messages: {
      'bn': require ('~/lang/bn.json'),
      'en': require ('~/lang/en.json')
    },
  });
}
