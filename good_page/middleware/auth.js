export default function(context) {
  console.log('[Middleware] Just Auth')
  if(!context.store.getters.isAuthenticated) {
    context.redirect('/authen/signin')
  }
}
