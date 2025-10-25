<template>
    <div class="ml-[20px] min-h-[70vh] px-[20px] py-[30px] w-[1000px] bg-[#fff] rounded-[var(--rounded-big)]">
        <div>
            <div>
                <template v-if="agreement">
                    <div v-if="agreement.title && agreement.content">
                        <h2 class="text-center">{{ agreement.title }}</h2>
                        <div v-html="agreement.content"></div>
                    </div>
                    <el-empty :description="t('protocolNotConfigured')"  :image-size="200" :image="img('static/resource/images/system/empty.png')" v-else />
                </template>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, reactive, watch } from 'vue'
import { getAgreementInfo } from '@/app/api/system'
import { useRoute } from 'vue-router';

const agreement = ref<any | null>(null)
const route = useRoute()
watch(() => route.query.key, (newVal, oldVal) => {
    if(route.query.key){
        getAgreementInfo(route.query.key).then(({ data }) => {
            agreement.value = data

            if(data.title){
                useHead({
                    title: data.title
                })
            }else {
                useHead({
                    title: route.query.key == 'service' ? '用户协议' : '隐私协议'
                })
            }

        }).catch(err => {
        })
    }
},{immediate: true})

</script>

<style lang="scss" scoped></style>
