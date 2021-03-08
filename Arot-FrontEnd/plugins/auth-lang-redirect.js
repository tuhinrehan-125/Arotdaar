export default ({ app }) => {
  let redirect = app.$auth.$storage.options.redirect
  console.log(redirect)
  for (var key in redirect) {
    redirect[key] = '/' + app.i18n.locale + redirect[key]
  }
  app.$auth.$storage.options.redirect = redirect
}
