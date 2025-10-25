<template>
<div class="loginPopup">
    <el-dialog v-model="dialogVisible" align-center width="430"  :before-close="beforeClose"  custom-class="login !rounded-[var(--rounded-big)]" :show-close="false" append-to-body>
        <div class="relative">
            <span class="iconfont icon-tubiaoV6-3 absolute top-[-33px] right-[-33px] text-[#fff] !text-[24px]" @click="handleClose"></span>
            <login v-if="type === 'login' && dialogVisible" @typeChange="typeChange"/>
            <register v-if="type === 'register' && dialogVisible" @typeChange="typeChange" />
        </div>
    </el-dialog>
</div>
</template>
<script lang="ts" setup>
import { ref,computed,watch } from 'vue'
import login from './login.vue'
import register from './register.vue'
import useMemberStore from '@/stores/member'

const memberStore = useMemberStore()
//弹框状态
const dialogVisible = computed(()=>{
    return memberStore.loginPopup
})
//弹框关闭
const beforeClose = (next)=>{
    memberStore.logClose()
    type.value = 'login'
    next()
}
const handleClose = ()=>{
    memberStore.logClose()
     type.value = 'login'
}
//判断当前是登录还是注册
let type = ref('login')
const typeChange = (val:any)=>{
    type.value = val
}
</script>
<style>
.login .el-dialog__header{
    padding: 0 !important;
}

.login .el-dialog__body{
    padding: 0 !important;
}
.login .el-dialog__headerbtn{
    z-index: 99;
}
</style>
<style lang="scss" scoped>
:deep(.el-form-item) {
    .el-input__wrapper {
        box-shadow: unset !important;
        border-radius: 0;
        &.is-focus {
            border: none;
        }
    }

    &.is-error {
        .el-input__wrapper {
            border: none;
        }
    }
}

:deep(.el-form-item__error) {
    padding-top: 5px;
}

.text-color {
    color: var(--el-color-primary);
}

</style>
