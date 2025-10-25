<template>
    <el-dialog v-model="showDialog" :title="formData.id ? t('updateFriendlyLink') : t('addFriendlyLink')" width="500px" class="diy-dialog-wrap" :destroy-on-close="true">
        <el-form :model="formData" label-width="120px" ref="formRef" :rules="formRules" class="page-form" v-loading="loading">
            <el-form-item :label="t('linkPic')">
                <upload-image v-model="formData.link_pic" />
            </el-form-item>
            <el-form-item :label="t('linkTitle')" prop="link_title">
                <el-input v-model="formData.link_title" clearable :placeholder="t('linkTitlePlaceholder')" class="input-width" maxlength="20" />
            </el-form-item>
            <el-form-item :label="t('linkUrl')" prop="link_url">
                <el-input v-model="formData.link_url" clearable :placeholder="t('linkUrlPlaceholder')" class="input-width" />
            </el-form-item>
            <el-form-item :label="t('sort')" prop="sort">
                <el-input v-model.trim="formData.sort" clearable :placeholder="t('sortPlaceholder')" class="input-width" show-word-limit maxlength="8" @keyup="filterNumber($event)" @blur="formData.sort = $event.target.value" />
            </el-form-item>
            <el-form-item :label="t('isShow')">
                <el-switch v-model="formData.is_show" :active-value="1" :inactive-value="0" />
            </el-form-item>
        </el-form>

        <template #footer>
            <span class="dialog-footer">
                <el-button @click="showDialog = false">{{ t('cancel') }}</el-button>
                <el-button type="primary" :loading="loading" @click="confirm(formRef)">{{ t('confirm') }}</el-button>
            </span>
        </template>
    </el-dialog>
</template>

<script lang="ts" setup>
import { ref, reactive, computed } from 'vue'
import { t } from '@/lang'
import type { FormInstance } from 'element-plus'
import { addFriendlyLink, editFriendlyLink, getFriendlyLinkInfo } from '@/app/api/web'

const showDialog = ref(false)
const loading = ref(false)

/**
 * 表单数据
 */
const initialFormData = {
    id: '',
    link_pic: '',
    link_title: '',
    link_url: '',
    sort: '',
    is_show: 1
}
const formData: Record<string, any> = reactive({ ...initialFormData })

const formRef = ref<FormInstance>()

// 正则表达式
const regExp: any = {
    number: /^\d{0,10}$/,
}

// 表单验证规则
const formRules = computed(() => {
    return {
        link_pic: [
            { required: true, message: t('linkPicPlaceholder'), trigger: 'blur' }
        ],
        link_title: [
            { required: true, message: t('linkTitlePlaceholder'), trigger: 'blur' }
        ],
        link_url: [
            { required: true, message: t('linkUrlPlaceholder'), trigger: 'blur' },
            {
                validator: (rule: any, value: string, callback: any) => {
                    const pattern = /^(http|https):\/\/.+/
                    if (value && !pattern.test(value)) {
                        callback(new Error(t('addressTips')))
                    } else { callback() }
                }
            }
        ],
        sort: [
            {
                trigger: 'blur',
                validator: (rule: any, value: any, callback: any) => {
                    if (isNaN(value) || !regExp.number.test(value)) {
                        callback(new Error(t('sortTips')))
                    } else {
                        callback()
                    }
                }
            }
        ],
    }
})

const emit = defineEmits(['complete'])

/**
 * 确认
 * @param formEl
 */
const confirm = async (formEl: FormInstance | undefined) => {
    if (loading.value || !formEl) return
    const save = formData.id ? editFriendlyLink : addFriendlyLink

    await formEl.validate(async (valid) => {
        if (valid) {
            loading.value = true

            const data = formData

            save(data).then(res => {
                loading.value = false
                showDialog.value = false
                emit('complete')
            }).catch(() => {
                loading.value = false
            })
        }
    })
}

const setFormData = async (row: any = null) => {
    Object.assign(formData, initialFormData)
    loading.value = true
    if (row) {
        const data = await (await getFriendlyLinkInfo(row.id)).data
        if (data) {
            Object.keys(formData).forEach((key: string) => {
                if (data[key] != undefined) formData[key] = data[key]
            })
        }
    }
    loading.value = false
}

defineExpose({
    showDialog,
    setFormData
})
</script>

<style lang="scss" scoped></style>
<style lang="scss">
.diy-dialog-wrap .el-form-item__label {
    height: auto !important;
}
</style>
