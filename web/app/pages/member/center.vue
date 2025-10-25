<template>
    <div class="ml-[20px] min-h-[70vh] px-[20px] py-[30px] w-[1000px] bg-[#fff] rounded-[var(--rounded-big)]">
        <div class="h-full"  v-loading="loading">
            <div>
                <div class="text-[18px] text-[#333] mb-[50px]">我的信息</div>
                <div v-if="info">
                    <el-form :model="info" class="form-wrap" label-width="120px" label-position="left">
                        <el-form-item :label="t('memberHeadimg')" class="pb-[20px] border-b-[1px] border-dashed border-[#ddd]">
                            <div class="w-full flex justify-between content-center items-center">
                                <img v-if="!info.headimg" class="w-[80px] h-[80px]" src="@/assets/images/default_headimg.png" alt="">
                                <img v-else :src="img(info.headimg)" class="w-[80px] h-[80px]" alt="">
                                <el-upload class="avatar-uploader" :show-file-list="false" v-bind="upload" ref="uploadRef">
                                    <span class="cursor-pointer text-primary">{{ t('edit') }}</span>
                                </el-upload>
                            </div>
                        </el-form-item>
                        <el-form-item :label="t('username')" class="pb-[20px] border-b-[1px] border-dashed border-[#ddd]">
                            <div class="w-full flex justify-between content-center">
                                <span>{{ info.username }}</span>
                            </div>
                        </el-form-item>
                        <el-form-item :label="t('nickname')" class="pb-[20px] border-b-[1px] border-dashed border-[#ddd]">
                            <div class="w-full flex justify-between content-center">
                                <div>
                                    <span>{{ updateNickname.value }}</span>
                                    <span v-if="currentLevel">(当前等级:{{currentLevel}})</span>
                                </div>
                                <span class="cursor-pointer text-primary" @click="updateNickname.modal = true">{{ t('edit')}}</span>
                            </div>
                        </el-form-item>
                        <el-form-item :label="t('mobile')" class="pb-[20px] border-b-[1px] border-dashed border-[#ddd]">
                            <div class="w-full flex justify-between content-center">
                                <span>{{ info.mobile }}</span>
                                <span  v-if="!info.mobile" class="cursor-pointer text-primary" @click="updateMobileDialog = true">{{ t('edit')}}</span>
                            </div>
                        </el-form-item>
                    </el-form>
                    <div class="flex justify-end mt-[38px]">
                        <span class="cursor-pointer w-[130px] h-[40px] leading-[40px]  text-center rounded-[4px] bg-[var(--el-color-primary)] text-white text-[14px]" @click="logoutFn">退出</span>
                    </div>
                </div>
            </div>
            <!-- 更改昵称 -->
            <el-dialog v-model="updateNickname.modal" :title="t('nickname')" width="380">
                <el-form :model="info">
                    <el-form-item>
                        <el-input v-model="updateNickname.value" autocomplete="off" />
                    </el-form-item>
                </el-form>
                <template #footer>
                    <span class="dialog-footer">
                        <el-button @click="updateNickname.modal = false">{{ t('cancel') }}</el-button>
                        <el-button type="primary" @click="updateNicknameConfirm">{{ t('confirm') }}</el-button>
                    </span>
                </template>
            </el-dialog>
              <!-- 更改手机号码 -->
              <el-dialog v-model="updateMobileDialog" :title="t('updateMobile')" width="420">
                <el-form :model="formData" ref="formRef" :rules="formRules" :validate-on-rule-change="false">
                    <el-form-item prop="mobile">
                            <el-input v-model="formData.mobile" :placeholder="t('mobilePlaceholder')" clearable>
                            </el-input>
                    </el-form-item>
                    <el-form-item prop="mobile_code">
                        <el-input v-model="formData.mobile_code" :placeholder="t('codePlaceholder')">
                            <template #suffix>
                                <sms-code :mobile="formData.mobile" type="login" v-model="formData.mobile_key" @click="sendSmsCode" ref="smsCodeRef"></sms-code>
                            </template>
                        </el-input>
                    </el-form-item>
                </el-form>
                <template #footer>
                    <span class="dialog-footer">
                        <el-button @click="updateMobileDialog = false">{{ t('cancel') }}</el-button>
                        <el-button type="primary" :loading="mobileLoading" @click="updateMobileConfirm">{{ t('confirm') }}</el-button>
                    </span>
                </template>
            </el-dialog>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref, computed } from 'vue'
import useMemberStore from '@/stores/member'
import useAppStore from '@/stores/app'
import { modifyMember, bindMobile, getMemberLevel} from '@/app/api/member'
import { ElMessage, ElMessageBox, UploadFile, UploadFiles, FormInstance } from 'element-plus'
import request from '@/utils/request'
import storage from '@/utils/storage'
import { getToken } from '@/utils/common'

const memberStore = useMemberStore()
const loading = ref(true)

//会员昵称
const updateNickname = reactive({
    modal: false,
    value: ''
})

const info:any = computed(() => {
    updateNickname.value = memberStore.info?.nickname;
    if (memberStore.info) loading.value = false;
    return memberStore.info;
})
const appStore = useAppStore()

// 获取会员等级
let currentLevel = ref('')
const getMemberLevelFn = () =>{
    getMemberLevel().then((res:any) =>{
        if(info.value && res.data && res.data.length){
            res.data.forEach((item:any,index:number)=>{
				if(item.level_id == info.value.member_level){
                    currentLevel.value = item.level_name
				}
			})
		}
    })
}
getMemberLevelFn()
const uploadRef = ref<any>(null)
const upload = computed(() => {
    const headers: Record<string, any> = {}
    headers.token = getToken()
    return {
        action: `${request.options.baseURL}/file/image`,
        limit: 1,
        headers,
        onSuccess: (response: any, uploadFile: UploadFile, uploadFiles: UploadFiles) => {
            let img = uploadFile?.response?.data?.url;
            if (response.code == 200 || response.code == 1) {
                modifyMember({
                    field: 'headimg',
                    value: img
                }).then(() => {
                    memberStore.info.headimg = img
                    uploadRef.value.clearFiles()
                })
            } else {
                uploadFile.status = 'fail'
                ElMessage({ message: response.msg, type: 'error' })
            }
        }
    }
})

// 修改会员名称
const updateNicknameConfirm = () => {
    if (!updateNickname.value) { ElMessage.error('会员昵称不能为空'); return }

    modifyMember({
        field: 'nickname',
        value: updateNickname.value
    }).then(res => {
        updateNickname.modal = false
    })
}

// 手机号
const updateMobileDialog = ref(false)
const formData = reactive({
    mobile: '',
    mobile_code: '',
    mobile_key: ''
})
const mobileLoading = ref(false)
const formRef = ref<FormInstance>()
const formRules = computed(() => {
    return {
        'mobile': [
            {
                required: true,
                message: t('mobilePlaceholder'),
                trigger: ['blur', 'change'],
            },
            {
                validator(rule: any, value: string, callback: any) {
                    const phonePattern = /^1[3456789]\d{9}$/
                    if (!phonePattern.test(value)) {
                        return callback(new Error(t('mobileTips')))
                    } else {
                        return callback()
                    }
                },
                message: t('mobileError'),
                trigger: ['blur'],
            }
        ],
        'mobile_code': {
            required: true,
            message: t('codePlaceholder'),
            trigger: ['change']
        }
    }
})

const smsCodeRef = ref<AnyObject | null>(null)
const sendSmsCode = async () => {
    await formRef.value?.validateField('mobile', async (valid, fields) => {
        if (valid) {
            smsCodeRef.value?.send()
        }
    })
}
const updateMobileConfirm = async () => {
    await formRef.value?.validate(async (valid, fields) => {
        if (valid) {
            if (mobileLoading.value) return
            mobileLoading.value = true
            bindMobile(formData).then((res) => {
                memberStore.getMemberInfo()
                mobileLoading.value = false
                updateMobileDialog.value = false
            }).catch(() => {
                mobileLoading.value = false
            })
        }
    })
}

// 退出登录
const logoutFn = () => {
    ElMessageBox.confirm('您确定要退出账号吗？', '提示',
        {
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            confirmButtonClass:'!bg-[var(--el-color-primary)] !border-[var(--el-color-primary)]',
            cancelButtonClass:'!border-[#dcdfe6]',
            type: 'warning'
        }
    ).then(() => {
        memberStore.logout()
        navigateTo(`/`)
    })
}
</script>

<style lang="scss" scoped>
.box-card {
    border: none !important;
}

::v-deep .form-wrap .el-form-item {
    align-items: center;
}
</style>
