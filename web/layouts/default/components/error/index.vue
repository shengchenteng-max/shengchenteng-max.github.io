<template>
    <div class="ml-[20px] min-h-[70vh] w-[1000px]  flex">
        <div class="m-auto">
            <div class="text-[#333] text-center text-[24px] mt-[35px] mb-[26px] ">请登录查看</div>
            <div class="w-[100px] h-[40px] leading-[40px] border-[1px] border-solid border-[#ccc] rounded-full text-center text-[14px] mx-auto cursor-pointer" @click="handleLogin">登录</div>
        </div>
    </div>
</template>

<script setup lang="ts">
import {ref, computed,watch} from 'vue'
import useMemberStore from '@/stores/member'

const memberStore = useMemberStore()
const handleLogin = ()=>{
    memberStore.logOpen()
}
</script>

<style scoped>

</style>
