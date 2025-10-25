<template>
    <div class="ml-[20px] min-h-[70vh] px-[20px] py-[30px] w-[1000px] bg-[#fff] rounded-[var(--rounded-big)]">
        <div class="h-full" v-loading="pointTableData.loading">
            <div>
                <div class="text-[18px] text-[#333] mb-[30px]">{{t('myPoint')}}</div>
                <div class="flex justify-center mb-[40px]">
                    <div class="mr-[160px] text-center">
                        <div class="text-[32px] text-primary font-600 mb-[10px]">{{ pointInfo.point||0  }}</div>
                        <div class="text-[#999] text-[14px]">当前积分</div>
                    </div>
                    <div class="mr-[160px] text-center">
                        <div class="text-[32px] text-[#333] font-600 mb-[10px]">{{ pointInfo.point_get||0 }}</div>
                        <div class="text-[#999] text-[14px]">累计积分</div>
                    </div>
                    <div class="mr-[160px] text-center">
                        <div class="text-[32px] text-[#333] font-600 mb-[10px]">{{ pointInfo.use||0  }}</div>
                        <div class="text-[#999] text-[14px]">累计消费</div>
                    </div>
                    <div class="text-center">
                        <div class="text-[32px] text-[#333] font-600 mb-[10px]">{{ pointInfo.point||0 }}</div>
                        <div class="text-[#999] text-[14px]">可用积分</div>
                    </div>
                </div>
                <div v-if="pointTableData.data.length && !pointTableData.loading">
                    <div class="pt-[20px] px-[20px]  rounded-[12px] min-h-[70%] mt-[30px] bg-[#fafafa]">
                        <div>
                            <template v-for="(item,index) in pointTableData.data" :key="index">
                                <div class="flex items-center justify-between mb-[20px] border-b-[1px] border-dashed border-[#eee]" v-for="(subItem,subIndex) in item.month_data" :key="subIndex">
                                    <div>
                                        <div class="font-[16px] mb-[14px] text-[#333]">{{ subItem.from_type_name }}</div>
                                        <div class="text-[14px] text-[#999] mb-[20px]">{{ subItem.create_time }}</div>
                                    </div>
                                    <div class="mb-[14px] text-[18px] price-font" :class="{'text-[#EF000C]' : subItem.account_data > 0, 'text-[#03B521]':subItem.account_data <= 0}">{{ subItem.account_data > 0 ? '+' + subItem.account_data : subItem.account_data }}</div>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="mt-[16px] flex justify-end">
                        <el-pagination v-model:current-page="pointTableData.page" v-model:page-size="pointTableData.limit" layout="prev, pager, next"  background hide-on-single-page :total="pointTableData.total" @size-change="loadPointList()" @current-change="loadPointList" />
                    </div>
                </div>
                <div v-if="!pointTableData.data.length && !pointTableData.loading">
                    <el-empty description="暂无数据" :image-size="200" :image="img('static/resource/images/system/empty.png')"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref } from 'vue'
import { getPointList, getMemberAccountPointcount } from '@/app/api/member'

//个人积分信息
const pointInfo = ref({});
const  getMemberAccountPointcountFn = () =>{
    getMemberAccountPointcount().then((res: any) =>{
        pointInfo.value = res.data
    })
}
getMemberAccountPointcountFn()
// 获取会员列表
const pointTableData = reactive({
    page: 1,
    limit: 10,
    total: 0,
    loading: true,
    data: []
})
const loadPointList = (page: number = 1) => {
    pointTableData.loading = true
    pointTableData.page = page

    getPointList({
        page: pointTableData.page,
        limit: pointTableData.limit,
    }).then((res: any) => {
        pointTableData.loading = false
        pointTableData.data = res.data.data
        pointTableData.total = res.data.total
    }).catch(() => {
        pointTableData.loading = false
    })
}
loadPointList()

</script>

<style lang="scss" scoped>
.box-card{
    border: none !important;
}
.text-color{
    color: var(--jjext-color-brand);
}
</style>
