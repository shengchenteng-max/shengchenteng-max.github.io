import { defineStore } from 'pinia'
import storage from '@/utils/storage'
import { getSiteInfo } from '@/app/api/system'

interface System {
    lang: string,
    site: Record<string, any>

}

const useSystemStore = defineStore('system', {
    state: (): System => {
        return {
            lang: storage.get('lang') ?? 'zh-cn',
            site: {
                front_end_name: '',
                site_name: ''
            }
        }
    },
    actions: {
        async getSiteInfoFn() {
            await getSiteInfo().then((res: any) => {
                this.site = res.data
                if (!('shop_web' in this.site.site_addons)) {
                    navigateTo('/app/index', { replace: true })
                }

            }).catch((err) => {

            })
        }
    }
})

export default useSystemStore
