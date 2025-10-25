<template>
    <div class="flex flex-wrap">
        <template v-if="limit == 1">
            <div class="rounded cursor-pointer overflow-hidden relative border border-solid border-color  mr-[10px]" :style="style">
                <div class="w-full h-full relative image-wrap" v-if="images.data.length">
                    <div class="w-full h-full flex items-center justify-center">
                        <el-image :src="img(images.data[0])" fit="contain"></el-image>
                    </div>
                    <div class="absolute z-[1] inset-0 image-mask  hidden">
                        <div class="flex items-center justify-center w-full h-full bg-black bg-opacity-60 operation">
                            <icon name="element-ZoomIn" color="#fff" size="18px" class="mr-[10px]" @click="previewImage()" />
                            <icon name="element-Delete" color="#fff" size="18px" v-if="status" @click="removeImage" />
                        </div>
                    </div>
                </div>
                <el-upload v-bind="upload" class="upload-file w-full h-full" :show-file-list="false" >
                    <div class="w-full h-full flex items-center justify-center flex-col">
                        <icon name="element-Plus" size="20px" color="var(--el-text-color-secondary)" />
                        <div class="leading-none text-xs mt-[10px] text-secondary">{{ imageText  }}</div>
                    </div>
                </el-upload>
            </div>
        </template>
        <template v-else>
            <div class="rounded cursor-pointer overflow-hidden relative border border-solid border-color mr-[10px] mb-[10px]" :style="style" v-for="(item, index) in images.data" :key="index">
                <div class="w-full h-full relative image-wrap">
                    <div class="w-full h-full flex items-center justify-center">
                        <el-image :src="img(item)" fit="contain"></el-image>
                    </div>
                    <div class="absolute z-[1] inset-0 image-mask  hidden">
                        <div class=" flex items-center justify-center w-full h-full  bg-black bg-opacity-60 operation">
                            <icon name="element-ZoomIn" color="#fff" size="18px" class="mr-[10px]" @click="previewImage(index)" />
                            <icon name="element-Delete" color="#fff" size="18px" v-if="status" @click="removeImage(index)" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-[6px] cursor-pointer overflow-hidden relative border border-dashed border-color bg-[#fafafa] hover:border-primary" :style="style" v-if="images.data.length < limit && status">
                <el-upload v-bind="upload" class="upload-file w-full h-full" :show-file-list="false" :multiple="true" :limit="limit">
                    <div class="w-full h-full flex items-center justify-center">
                        <icon name="element-Plus" size="28px" color="var(--el-text-color-secondary)" />
                        <div class="leading-none text-xs mt-[10px] text-secondary">{{ imageText  }}</div>
                    </div>
                </el-upload>
            </div>
        </template>
    </div>
    <el-image-viewer :url-list="previewImageList" v-if="imageViewer.show" @close="imageViewer.show = false"
        :initial-index="imageViewer.index" :zoom-rate="1" :hide-on-click-modal="true" />
</template>

<script lang="ts" setup>
import { reactive,computed,watch,toRaw } from 'vue'
import { getToken,img } from '@/utils/common'
import { UploadFile, ElMessage, UploadFiles } from 'element-plus'

const prop = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    data: {
        type: Array,
        default: []
    },
    width: {
        type: String,
        default: '100px'
    },
    height: {
        type: String,
        default: '100px'
    },
    // 上传图片的文字
    imageText: {
        type: String
    },
    // 限制图片的数量
    limit: {
        type: Number,
        default: 1
    },
    // 控制删除按钮的展示
    status:{
        type:Boolean,
        default:true
    }
})

const emit = defineEmits(['update:modelValue','success'])

const value = computed({
    get() {
        return prop.modelValue
    },
    set(value) {
        emit('update:modelValue', value)
    }
})

const images: Record<string, any> = reactive({
    data: []
})

let previewImageList: string[] = reactive([])

const setValue = () => {
    value.value = toRaw(images.data).toString()
    previewImageList = toRaw(images.data).map((url: string) => { return img(url) })
}

watch(() => value.value, () => {
    images.data = [
        ...value.value.split(',').filter((item: string) => { return item })
    ]
    setValue()
}, { immediate: true })

const style = computed(() => {
    return {
        width: prop.width,
        height: prop.height
    }
})

const headers: Record<string, any> = {}
headers.token = getToken()

const runtimeConfig = useRuntimeConfig()

let url = runtimeConfig.public.VITE_APP_BASE_URL || `${location.origin}/api/`
const upload: Record<string, any> = {
    action: `${url}/file/image`,
    headers,
    accept: '.png,.jpg,.jpeg',
    // 检查是否超过数量限制
    beforeUpload: (file: File) => {
        if (images.data.length >= prop.limit) {
            ElMessage.error(`最多只能上传 ${prop.limit} 张图片`);
            return false;
        }
        return true; // 允许上传
    },
    onSuccess: (response: any) => {
        images.data.push(response.data.url);
        setValue();
    },
    onExceed: () => {
        ElMessage.error(`最多只能上传 ${prop.limit} 张图片`);
    },
};

/**
 * 删除图片
 * @param index
 */
 const removeImage = (index: number = 0) => {
    images.data.splice(index, 1)
    setValue()
}

/**
 * 查看图片
 */
const imageViewer = reactive({
    show: false,
    index: 0
})

const previewImage = (index: number = 0) => {
    imageViewer.show = true
    imageViewer.index = index
}
</script>

<style lang="scss">
.upload-file .el-upload {
    width: 100%;
    height: 100%;
}
.image-wrap:hover .image-mask {
    display: block;
}
</style>
