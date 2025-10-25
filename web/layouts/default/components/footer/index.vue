<template>
    <div class="flex h-[220px] min-w-[1200px] bg-[#3F4045]">
		<div class="mt-[70px] w-full">
            <p class="text-center text-[#999]" v-if="friendlyLink.length">
				<span>友情链接：</span>
				<template v-for="(item,index) in friendlyLink" :key="index">
					<NuxtLink :to="item.link_url" target="_blank">
						<span>{{item.link_title}}</span>
						<span class="mx-[10px] text-[#D9D9D9]"  v-if="(index + 1) != friendlyLink.length">|</span>
					</NuxtLink>
				</template>
			</p>
            <p class="text-center mt-[20px] text-[#999]" v-if="copyright">
                <NuxtLink :to="copyright.gov_url" v-if="copyright.gov_record">
                    <span class="mr-2">公安备案号:{{ copyright.gov_record }}</span>
                </NuxtLink>
				<NuxtLink to="https://beian.miit.gov.cn/" v-if="copyright.icp">
					<span class="mr-2">备案号:{{ copyright.icp }}</span>
				</NuxtLink>
                <NuxtLink :to="copyright.copyright_link">
                    <span class="mr-2" v-if="copyright.company_name">{{ copyright.company_name }}</span>
                    <span class="mr-2" v-if="copyright.copyright_desc">©{{ copyright.copyright_desc }}</span>
                </NuxtLink>
			</p>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { getCopyRight } from '@/app/api/system';
import { reactive, ref } from 'vue'
import { getFriendlyLink } from '@/app/api/system'

const copyright = ref(null);
const getCopy = () => {
    getCopyRight().then(({ data }) => {
        copyright.value = data
    })
}
getCopy()

const friendlyLink = ref([]) // 格式：{ link_title: '', link_url: '' }

const getFriendlyLinkFn = () =>{
	getFriendlyLink().then((res:any) =>{
		friendlyLink.value = res.data
	})
}
getFriendlyLinkFn()
</script>

<style lang="scss" scoped>

</style>
