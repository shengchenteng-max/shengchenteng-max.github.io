import { defineStore } from 'pinia'
import storage from '@/utils/storage'
import { useCssVar } from '@vueuse/core'
import { useCssVar } from '@vueuse/core'
import { getInstalledAddonList } from '@/app/api/addon'


interface System {
    menuIsCollapse: boolean,
    dark: boolean,
    theme: string,
    lang: string,
    apps: Record<string, any>[],
    addons: Record<string, any>[]
}

const theme = storage.get('theme') ?? {}

const useSystemStore = defineStore('system', {
    state: (): System => {
        return {
            menuIsCollapse: false,
            dark: theme.dark ?? false,
            theme: theme.theme ?? '#273de3',
            lang: storage.get('lang') ?? 'zh-cn',
            apps: [],
            addons: []
        }
    },
    actions: {
        setTheme(state: string, value: any) {
            this[state] = value
            theme[state] = value
            storage.set({ key: 'theme', data: theme })
        },
        toggleMenuCollapse(value: boolean) {
            this.menuIsCollapse = value
            storage.set({ key: 'menuiscollapse', data: value })
            useCssVar('--aside-width').value = value ? 'calc(var(--el-menu-icon-width) + var(--el-menu-base-level-padding) * 2)' : '210px'
        },
        /**
         * 获取已安装的插件和应用
         */
        async getInstallAddons() {
            await getInstalledAddonList().then(({ data }) => {
                const apps = [], addons = []
                Object.keys(data).forEach(key => {
                    const item = data[key]
                    item.type == 'app' ? apps.push(item) : addons.push(item)
                })
                this.addons = addons
                this.apps = apps
            }).catch()
        }
    }
})

export default useSystemStore
