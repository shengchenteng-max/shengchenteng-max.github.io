<template>
    <div class="w-[180px] flex-shrink-0">
        <div class="bg-[#fff] pt-[30px] pr-[30px] pb-[21px] pl-[45px] rounded-[var(--rounded-big)]">
            <el-collapse v-model="activeNames">
                <el-collapse-item name="1" class="!mb-[24px]">
                    <template #title>
                        <div class="flex items-center">
                            <span class="text-[16px]">账户设置</span>
                        </div>
                    </template>
                    <div class="text-[14px] leading-[24px] cursor-pointer text-[#666]" :class="{'!text-primary': appStore.route == '/app/member/center'}"  @click="router.push('/app/member/center')">个人资料</div>
                </el-collapse-item>
                <el-collapse-item name="2" class="!mb-[24px]">
                    <template #title>
                        <div class="flex items-center">
                            <span class="text-[16px]">我的账户</span>
                        </div>
                    </template>
                    <div class="text-[14px] leading-[24px] cursor-pointer text-[#666] mb-[24px]" :class="{'!text-primary': appStore.route == '/app/member/point'}"  @click="router.push('/app/member/point')">我的积分</div>
                    <div class="text-[14px] leading-[24px] cursor-pointer text-[#666]" :class="{'!text-primary': appStore.route == '/app/member/balance'}" @click="router.push('/app/member/balance')">我的余额</div>
                </el-collapse-item>
                <el-collapse-item name="7" class="!mb-[24px]">
                    <template #title>
                        <div class="flex items-center">
                            <span class="text-[16px] oppoSans-M">规则协议</span>
                        </div>
                    </template>
                    <div class="text-[14px] leading-[24px] cursor-pointer text-[#666] mb-[24px]" :class="{'!text-primary': appStore.route == '/app/auth/agreement' && route.query.key == 'service'}" @click="router.push({path:'/app/auth/agreement',query:{key:'service'}})">用户协议</div>
                    <div class="text-[14px] leading-[24px] cursor-pointer text-[#666]" :class="{'!text-primary': appStore.route == '/app/auth/agreement' && route.query.key == 'privacy'}" @click="router.push({path:'/app/auth/agreement',query:{key:'privacy'}})">隐私协议</div>
                </el-collapse-item>
            </el-collapse>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import useAppStore from '@/stores/app'
import { useRouter, useRoute} from 'vue-router'

const appStore = useAppStore()
const router = useRouter()
const route = useRoute()
const activeNames = ref(['1','2','3','4','5','6','7'])
</script>

<style lang="scss" scoped>
:deep(.el-collapse){
    border:none !important;
}
:deep(.el-collapse-item__wrap){
    border:none !important;
}
:deep(.el-collapse-item__header){
    --el-collapse-header-height: auto !important;
    --el-collapse-header-font-size: 16px;
    border:none !important;
    margin-bottom: 24px;
}
:deep(.el-collapse-item__content){
    padding-bottom:0 !important;
}

</style>