<template>
    <div class="main-container">
        <el-card class="box-card !border-none" shadow="never">
            <div class="flex justify-between items-center mb-[20px]">
                <span class="text-page-title">{{ pageName }}</span>
            </div>

            <el-table :data="avdPositionTableData.data" size="large" v-loading="avdPositionTableData.loading">
                <template #empty>
                    <span>{{ !avdPositionTableData.loading ? t('emptyData') : '' }}</span>
                </template>
                <el-table-column prop="ap_name" :label="t('apName')" min-width="120" />
                <el-table-column prop="keywords" :label="t('keywords')" min-width="120" />
                <el-table-column :label="t('operation')" fixed="right" align="right" min-width="160">
                    <template #default="{ row }">
                        <el-button type="primary" link @click="toLink(row)">{{ t('manageAdv') }}</el-button>
                    </template>
                </el-table-column>

            </el-table>
        </el-card>
    </div>
</template>

<script lang="ts" setup>
import { reactive } from 'vue'
import { t } from '@/lang'
import { getAvdPositionList } from '@/app/api/web'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()
const pageName = route.meta.title
const avdPositionTableData: any = reactive({
    loading: true,
    data: []
})

// 获取广告位列表
const loadAvdPositionList = () => {
    getAvdPositionList({}).then(res => {
        avdPositionTableData.loading = false
        avdPositionTableData.data = res.data
    }).catch(() => {
        avdPositionTableData.loading = false
    })
}
loadAvdPositionList()
const toLink = (data: any) => {
    router.push(`/web/adv?adv_key=${data.keywords}&ap_name=${data.ap_name}`)
}
</script>

<style lang="scss" scoped>
</style>
