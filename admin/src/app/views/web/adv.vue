<template>
    <div class="main-container">
        <el-card class="box-card !border-none" shadow="never">
            <div class="flex justify-between items-center mb-[15px] ml-[15px]">
                <div class="flex items-center">
                    <div class="text-[#666] cursor-pointer text-[14px]" @click="router.push(`/web/adv_position`)">
                        <span class="iconfont iconxiangzuojiantou !text-xs"></span>
                        <span class="ml-[1px]">{{ t('returnToPreviousPage') }}</span>
                    </div>
                    <span class="text-[#999] mx-[12px]">|</span>
                    <span class="right">{{ pageName }}</span>
                </div>
                <el-button type="primary" @click="addEvent">{{ t('addAdv') }}</el-button>
            </div>
            <div class="mt-[10px]">
                <el-table :data="advTable.data" size="large" v-loading="advTable.loading">
                    <template #empty>
                        <span>{{ !advTable.loading ? t('emptyData') : '' }}</span>
                    </template>
                    <el-table-column prop="adv_title" :label="t('advName')" min-width="120" />
                    <el-table-column :label="t('advUrl')" min-width="120">
                        <template #default="{ row }">
                            <div>{{ row.adv_url ? row.adv_url.url : '' }}</div>
                        </template>
                    </el-table-column>
                    <el-table-column prop="ap_name" :label="t('advPosition')" min-width="120" />
                    <el-table-column :label="t('advImg')" min-width="180">
                        <template #default="{ row }">
                            <div class="w-[40px] h-[40px] flex items-center">
                                <el-image :src="img(row.adv_image)" :zoom-rate="1.2" :max-scale="7" :min-scale="0.2" :preview-src-list="[img(row.adv_image)]" :initial-index="4" fit="cover" />
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column :label="t('sort')" min-width="120">
                        <template #default="{ row }">
                            <el-input v-model.trim="row.sort" class="!w-[70px]" maxlength="8" @blur="sortInputListener(row.sort, row)" />
                        </template>
                    </el-table-column>
                    <el-table-column :label="t('operation')" fixed="right" min-width="120" align="right">
                        <template #default="{ row }">
                            <el-button type="primary" link @click="editEvent(row)">{{ t('edit') }}</el-button>
                            <el-button type="primary" link @click="deleteEvent(row.adv_id)">{{ t('delete') }}</el-button>
                        </template>
                    </el-table-column>

                </el-table>
                <div class="mt-[16px] flex justify-end">
                    <el-pagination v-model:current-page="advTable.page" v-model:page-size="advTable.limit"
                        layout="total, sizes, prev, pager, next, jumper" :total="advTable.total"
                        @size-change="loadAdvList()" @current-change="loadAdvList" />
                </div>
            </div>

            <edit ref="editAdvDialog" @complete="loadAdvList" />
        </el-card>
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref } from 'vue'
import { t } from '@/lang'
import { getAdvList, deleteAdv, editAdvSort } from '@/app/api/web'
import { img, debounce } from '@/utils/common'
import { ElMessageBox, ElMessage } from 'element-plus'
import Edit from '@/app/views/web/components/adv-edit.vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()
const pageName = route.meta.title
const advKey = route.query.adv_key
const apName = route.query.ap_name
const advTable = reactive({
    page: 1,
    limit: 10,
    total: 0,
    loading: true,
    data: []
})

/**
 * 获取广告列表
 */
const loadAdvList = (page: number = 1) => {
    advTable.loading = true
    advTable.page = page

    getAdvList({
        page: advTable.page,
        limit: advTable.limit,
        adv_key: advKey
    }).then(res => {
        advTable.loading = false
        advTable.data = res.data.data
        advTable.total = res.data.total
    }).catch(() => {
        advTable.loading = false
    })
}
loadAdvList()

const editAdvDialog: Record<string, any> | null = ref(null)

/**
 * 添加广告
 */
const addEvent = () => {
    editAdvDialog.value.setFormData({adv_key: advKey, ap_name: apName})
    editAdvDialog.value.showDialog = true
}

/**
 * 编辑广告
 * @param data
 */
const editEvent = (data: any) => {
    editAdvDialog.value.setFormData(data)
    editAdvDialog.value.showDialog = true
}

/**
 * 删除广告
 */
const deleteEvent = (id: number) => {
    ElMessageBox.confirm(t('advDeleteTips'), t('warning'),
        {
            confirmButtonText: t('confirm'),
            cancelButtonText: t('cancel'),
            type: 'warning'
        }
    ).then(() => {
        deleteAdv(id).then(() => {
            loadAdvList()
        }).catch(() => {
        })
    })
}

// 正则表达式
const regExp = {
    number: /^\d{0,10}$/,
    digit: /^\d{0,10}(.?\d{0,2})$/
}

// 修改排序号
const sortInputListener = debounce((sort, row) => {
    if (isNaN(sort) || !regExp.number.test(sort)) {
        ElMessage({
            type: 'warning',
            message: `${t('sortTips')}`
        })
        return
    }
    if (sort > 99999999) {
        row.sort = 99999999
    }
    editAdvSort({
        id: row.adv_id,
        sort
    }).then((res: any) => {
        loadAdvList()
    })
})
</script>

<style lang="scss" scoped>
.input-width-sort {
    width: 70px;
}
</style>
