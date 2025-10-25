<template>
    <div class="ml-[20px] min-h-[70vh] px-[20px] py-[30px] w-[1000px] bg-[#fff] rounded-[var(--rounded-big)]">
        <div  class="h-full" v-loading="balanceTableData.loading">
            <div>
                <div class="text-[18px] text-[#333] mb-[30px]">{{t('myBalance')}}</div>
                <div class="text-center mb-[40px]">
                    <div class="text-[32px] text-[#333] font-600 mb-[10px]">{{ memberStore.info ? moneyFormat((parseFloat(memberStore.info.balance) + parseFloat(memberStore.info.money)).toString()) : '0.00'  }}</div>
                    <div class="text-[#999] text-[14px]">账户余额(元)</div>
                </div>
                <div class="flex flex-wrap">
                    <div v-for="(item,index) in accountTypeList" :key="index" class="cursor-pointer relative text-[16px] mr-[50px] text-[#666] flex items-center justify-center" :class="{'class-select': item.key == balanceTableData.params.trade_type}" @click="fromTypeFn(item.key)">{{item.name}}</div>
                </div>
                <div v-if="balanceTableData.data.length && !balanceTableData.loading">
                    <div class="pt-[20px] px-[20px]  rounded-[12px] min-h-[63%] mt-[30px] bg-[#fafafa]"  >
                        <div >
                            <div class="flex items-center justify-between mb-[20px] border-b-[1px] border-dashed border-[#eee]" v-for="(item,index) in balanceTableData.data" :key="index">
                                <div>
                                    <div class="font-[16px] mb-[14px] text-[#333]">{{ item.from_type_name }}</div>
                                    <div class="text-[14px] text-[#999] mb-[20px]">{{ item.create_time }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="mb-[14px] text-[18px] price-font"  :class="{'text-[#EF000C]' :item.account_data > 0, 'text-[#03B521]':item.account_data <= 0}">{{ item.account_data > 0 ? '+' + item.account_data : item.account_data }}</div>
                                    <div class="text-[14px] text-[#999] mb-[20px]">余额 {{item.account_sum}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-[30px] flex justify-center">
                        <el-pagination v-model:current-page="balanceTableData.page" v-model:page-size="balanceTableData.limit" layout="prev, pager, next" background hide-on-single-page :total="balanceTableData.total" @size-change="loadBalanceList()" @current-change="loadBalanceList" />
                    </div>
                </div>
                <div v-if="!balanceTableData.data.length && !balanceTableData.loading">
                    <el-empty description="暂无数据" :image-size="200" :image="img('static/resource/images/system/empty.png')"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref } from 'vue'
import useMemberStore from '@/stores/member'
import { moneyFormat }  from '@/utils/common'
import { getBalanceListAll } from '@/app/api/member'

const memberStore = useMemberStore()

//获取数据来源类型
const accountTypeList = ref([
	{name:'全部',key:''},
	{name:'收入',key:'income'},
	{name:'支出',key:'disburse'},
	{name:'提现',key:'cash_out'},
])

// 获取会员列表
const balanceTableData = reactive<any>({
    page: 1,
    limit: 10,
    total: 0,
    loading: true,
    data: [],
    params:{
        trade_type:''
    }
})
const loadBalanceList = (page: number = 1) => {
    balanceTableData.loading = true
    balanceTableData.page = page

    getBalanceListAll({
        page: balanceTableData.page,
        limit: balanceTableData.limit,
        ...balanceTableData.params
    }).then((res: any) => {
        balanceTableData.loading = false
        balanceTableData.data = res.data.data
        balanceTableData.total = res.data.total
    }).catch(() => {
        balanceTableData.loading = false
    })
}
loadBalanceList()

// 分类点击
const fromTypeFn = (key: string)=>{
    balanceTableData.params.trade_type = key
	loadBalanceList()
}

</script>

<style lang="scss" scoped>
.text-color{
    color: var(--jjext-color-brand);
}
.class-select{
    color: var( --el-color-primary);
    &::after{
        background: #e93323;
        content: "";
        height: 2px;
        position: absolute;
        top: 31px;
        width: 22px;
    }
}
</style>
