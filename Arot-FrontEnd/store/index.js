export const strict = false
export const state = () => ({
  barColor: 'rgba(0, 0, 0, .8), rgba(0, 0, 0, .8)',
  barImage: '',
  drawer: null,
  isModalOpened: false,
  isViewModalOpened: false,
  locales: ['bn', 'en'],
  locale: 'bn',
})
export const getters = {
  modal(state) {
    return state.isModalOpened
  },
  viewmodal(state) {
    return state.isViewModalOpened
  }
}
export const mutations = {
  SET_BAR_IMAGE(state, payload) {
    state.barImage = payload
  },
  SET_DRAWER(state, payload) {
    state.drawer = payload
  },
  SET_MODAL(state, payload) {
    state.isModalOpened = payload
  },
  SET_VIEW_MODAL(state, payload) {
    state.isViewModalOpened = payload
  },
  SET_LANG(state, locale) {
    if (state.locales.indexOf(locale) !== -1) {
      state.locale = locale
    }
  }
}


