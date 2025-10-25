import { defineStore } from 'pinia'
import { getMemberInfo } from '@/app/api/member'
import { logout } from '@/app/api/auth'

interface Member {
    token: string | null
    info: Record<string, any> | null,
    loginPopup:boolean
}

const useMemberStore = defineStore('member', {
    state: (): Member => {
        return {
            token: useCookie('token').value,
            info: null,
            loginPopup:false
        }
    },
    actions: {
        async setToken(token: string) {
            this.token = token
            useCookie('token').value = token
            await this.getMemberInfo()
        },
        async getMemberInfo() {
            if (!this.token) return
            await getMemberInfo()
                .then((res: any) => {
                    this.info = res.data
                })
                .catch((err) => {
                    this.logout()
                })
        },
        logout() {
            if (!this.token) return
            this.token = ''
            this.info = null
            useCookie('token').value = null
            logout().then().catch()
        },
        logOpen(){
            this.loginPopup = true
        },
        logClose(){
            this.loginPopup = false
        }
    }
})

export default useMemberStore
