<template>
    <div class="main-container">
        <el-card class="box-card !border-none" shadow="never">

            <div class="flex justify-between items-center">
                <span class="text-lg">{{ pageName }}</span>
                <el-button type="primary" @click="addEvent">{{ t('addFriendlyLink') }}</el-button>
            </div>

            <el-card class="box-card !border-none my-[10px] table-search-wrap" shadow="never">
                <el-form :inline="true" :model="friendlyLinkTable.searchParam" ref="searchFormRef">
                    <el-form-item :label="t('linkTitle')" prop="link_title">
                        <el-input v-model="friendlyLinkTable.searchParam.link_title" :placeholder="t('linkTitlePlaceholder')" />
                    </el-form-item>

                    <el-form-item>
                        <el-button type="primary" @click="loadFriendlyLinkList()">{{ t('search') }}</el-button>
                        <el-button @click="resetForm(searchFormRef)">{{ t('reset') }}</el-button>
                    </el-form-item>
                </el-form>
            </el-card>

            <div class="mt-[10px]">
                <el-table :data="friendlyLinkTable.data" size="large" v-loading="friendlyLinkTable.loading">
                    <template #empty>
                        <span>{{ !friendlyLinkTable.loading ? t('emptyData') : '' }}</span>
                    </template>
                    <el-table-column prop="link_title" :label="t('linkTitle')" min-width="120" />
                    <el-table-column prop="link_url" :label="t('linkUrl')" min-width="200" />
                    <el-table-column prop="sort" :label="t('sort')" min-width="120">
                        <template #default="{ row }">
                            <el-input v-model.trim="row.sort" class="!w-[70px]" maxlength="8" @blur="sortInputListener(row.sort, row)" />
                        </template>
                    </el-table-column>
                    <el-table-column :label="t('isShow')" min-width="180" align="center">
                        <template #default="{ row }">
                            {{ row.is_show == 1 ? t('show') : t('hidden') }}
                        </template>
                    </el-table-column>

                    <el-table-column :label="t('operation')" fixed="right" min-width="120" align="right">
                        <template #default="{ row }">
                            <el-button type="primary" link @click="editEvent(row)">{{ t('edit') }}</el-button>
                            <el-button type="primary" link @click="deleteEvent(row.id)">{{ t('delete') }}</el-button>
                        </template>
                    </el-table-column>

                </el-table>
                <div class="mt-[16px] flex justify-end">
                    <el-pagination v-model:current-page="friendlyLinkTable.page" v-model:page-size="friendlyLinkTable.limit"
                        layout="total, sizes, prev, pager, next, jumper" :total="friendlyLinkTable.total"
                        @size-change="loadFriendlyLinkList()" @current-change="loadFriendlyLinkList" />
                </div>
            </div>

            <edit ref="editFriendlyLinkDialog" @complete="loadFriendlyLinkList" />
        </el-card>
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref } from 'vue'
import { t } from '@/lang'
import { getFriendlyLinkList, deleteFriendlyLink, editFriendlyLinkSort } from '@/app/api/web'
import { debounce } from '@/utils/common'
import { ElMessageBox, ElMessage, FormInstance } from 'element-plus'
import Edit from '@/app/views/web/components/friendly-link-edit.vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const pageName = route.meta.title

const friendlyLinkTable = reactive({
    page: 1,
    limit: 10,
    total: 0,
    loading: true,
    data: [],
    searchParam: {
        link_title: ''
    }
})

const searchFormRef = ref<FormInstance>()

/**
 * 获取友情链接列表
 */
const loadFriendlyLinkList = (page: number = 1) => {
    friendlyLinkTable.loading = true
    friendlyLinkTable.page = page

    getFriendlyLinkList({
        page: friendlyLinkTable.page,
        limit: friendlyLinkTable.limit,
        ...friendlyLinkTable.searchParam
    }).then(res => {
        friendlyLinkTable.loading = false
        friendlyLinkTable.data = res.data.data
        friendlyLinkTable.total = res.data.total
    }).catch(() => {
        friendlyLinkTable.loading = false
    })
}
loadFriendlyLinkList()

const editFriendlyLinkDialog: Record<string, any> | null = ref(null)

/**
 * 添加友情链接
 */
const addEvent = () => {
    editFriendlyLinkDialog.value.setFormData()
    editFriendlyLinkDialog.value.showDialog = true
}

/**
 * 编辑友情链接
 * @param data
 */
const editEvent = (data: any) => {
    editFriendlyLinkDialog.value.setFormData(data)
    editFriendlyLinkDialog.value.showDialog = true
}

/**
 * 删除友情链接
 */
const deleteEvent = (id: number) => {
    ElMessageBox.confirm(t('friendlyLinkDeleteTips'), t('warning'),
        {
            confirmButtonText: t('confirm'),
            cancelButtonText: t('cancel'),
            type: 'warning'
        }
    ).then(() => {
        deleteFriendlyLink(id).then(() => {
            loadFriendlyLinkList()
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
    editFriendlyLinkSort({
        id: row.id,
        sort
    }).then((res: any) => {
        loadFriendlyLinkList()
    })
})
const resetForm = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.resetFields()
    loadFriendlyLinkList()
}
</script>

<style lang="scss" scoped>
</style>
