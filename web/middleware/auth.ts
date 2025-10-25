
import useAppStore from '@/stores/app'

export default defineNuxtRouteMiddleware((to, from) => {
    if (!getToken()) {
        useAppStore().$patch(state => {
            state.route = to.path
        })
        // useLogin().setLoginBack(to)
        // return navigateTo('/auth/login')
    }
})