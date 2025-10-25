<template>
    <div class="main-container">
        <el-card class="box-card !border-none" shadow="never">

            <div class="flex justify-between items-center">
                <span class="text-lg">{{ pageName }}</span>
                <el-button type="primary" @click="addEvent">{{ t('addNav') }}</el-button>
            </div>

            <el-card class="box-card !border-none my-[10px] table-search-wrap" shadow="never">
                <el-form :inline="true" :model="navTable.searchParam" ref="searchFormRef">
                    <el-form-item :label="t('navTitle')" prop="nav_title">
                        <el-input v-model="navTable.searchParam.nav_title" :placeholder="t('navTitlePlaceholder')" maxlength="20" />
                    </el-form-item>

                    <el-form-item>
                        <el-button type="primary" @click="loadNavList()">{{ t('search') }}</el-button>
                        <el-button @click="resetForm(searchFormRef)">{{ t('reset') }}</el-button>
                    </el-form-item>
                </el-form>
            </el-card>

            <div class="mt-[10px]">
                <el-table :data="navTable.data" size="large" v-loading="navTable.loading">
                    <template #empty>
                        <span>{{ !navTable.loading ? t('emptyData') : '' }}</span>
                    </template>
                    <el-table-column prop="nav_title" :label="t('navTitle')" min-width="120" />
                    <el-table-column prop="nav_url" :label="t('navUrl')" min-width="120" >
                        <template #default="{ row }">
                            <div>{{ row.nav_url ? row.nav_url.url : '' }}</div>
                        </template>
                    </el-table-column>
                    <el-table-column prop="sort" :label="t('sort')" min-width="120">
                        <template #default="{ row }">
                            <el-input v-model.trim="row.sort" class="!w-[70px]" maxlength="8" @blur="sortInputListener(row.sort, row)" />
                        </template>
                    </el-table-column>
                    <el-table-column :label="t('isBlank')" min-width="180" align="center" >
                        <template #default="{ row }">
                            {{ row.is_blank == 1 ? t('yes') : t('no') }}
                        </template>
                    </el-table-column>
                    <el-table-column :label="t('createTime')" min-width="180" align="center">
                        <template #default="{ row }">
                            {{ row.create_time || '' }}
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
                    <el-pagination v-model:current-page="navTable.page" v-model:page-size="navTable.limit"
                        layout="total, sizes, prev, pager, next, jumper" :total="navTable.total"
                        @size-change="loadNavList()" @current-change="loadNavList" />
                </div>
            </div>

            <edit ref="editNavDialog" @complete="loadNavList" />
        </el-card>
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref } from 'vue'
import { t } from '@/lang'
import { debounce } from '@/utils/common'
import { getNavList, deleteNav, editNavSort } from '@/app/api/web'
import { ElMessageBox, FormInstance, ElMessage } from 'element-plus'
import Edit from '@/app/views/web/components/nav-edit.vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const pageName = route.meta.title

const navTable = reactive({
    page: 1,
    limit: 10,
    total: 0,
    loading: true,
    data: [],
    searchParam: {
        nav_title: ''
    }
})

const searchFormRef = ref<FormInstance>(null)

/**
 * 获取PC导航管理列表
 */
const loadNavList = (page: number = 1) => {
    navTable.loading = true
    navTable.page = page

    getNavList({
        page: navTable.page,
        limit: navTable.limit,
        ...navTable.searchParam
    }).then(res => {
        navTable.loading = false
        navTable.data = res.data.data
        navTable.total = res.data.total
    }).catch(() => {
        navTable.loading = false
    })
}
loadNavList()

const editNavDialog: Record<string, any> | null = ref(null)

/**
 * 添加PC导航管理
 */
const addEvent = () => {
    editNavDialog.value.setFormData()
    editNavDialog.value.showDialog = true
}

/**
 * 编辑PC导航管理
 * @param data
 */
const editEvent = (data: any) => {
    editNavDialog.value.setFormData(data)
    editNavDialog.value.showDialog = true
}

/**
 * 删除PC导航管理
 */
const deleteEvent = (id: number) => {
    ElMessageBox.confirm(t('navDeleteTips'), t('warning'),
        {
            confirmButtonText: t('confirm'),
            cancelButtonText: t('cancel'),
            type: 'warning'
        }
    ).then(() => {
        deleteNav(id).then(() => {
            loadNavList()
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
    editNavSort({
        id: row.id,
        sort
    }).then((res: any) => {
        loadNavList()
    })
})
const resetForm = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.resetFields()
    loadNavList()
}
</script>

<style lang="scss" scoped>
</style>
