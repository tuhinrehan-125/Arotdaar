export default function ({route,store, redirect }) {
  if (!store.state.user) {
    return redirect("/");
  }
  else {
    return redirect('/dashboard')
  }
}
