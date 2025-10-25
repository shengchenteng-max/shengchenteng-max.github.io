<template>
    <el-container class="w-screen h-screen">
        <el-header>
            <layout-header />
        </el-header>
        <el-main class="p-0 min-w-[1200px]">
            <div class="bg-page pt-6 pb-6">
                <div class="main-container flex justify-between">
                    <sidebar></sidebar>
                    <div v-if="agreeShow"><slot></slot></div>
                    <div v-else><layout-error ></layout-error></div>
                </div>
            </div>
        </el-main>
    </el-container>
</template>

<script lang="ts" setup>
import layoutHeader from './default/components/header/index.vue'
import layoutError from './default/components/error/index.vue'
import sidebar from '@/components/sidebar/index.vue'
import { getToken } from '@/utils/common'
import { useRouter } from 'vue-router'

const router = useRouter()
let agreeShow = ref(false)
watch(()=> router.currentRoute.value.path ,(newValue)=>{
    if(router.currentRoute.value.path == '/auth/agreement' || router.currentRoute.value.path == '/app/auth/agreement' || getToken() ){
        agreeShow.value = true
    }else{
        agreeShow.value = false
    }
},{immediate:true,deep: true})
</script>

<style lang="scss" scoped>
.el-header {
    --el-header-padding: 0;
}

.el-main {
    --el-main-padding: 0;
}
</style>
