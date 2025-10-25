<template>
    <div class="w-screen h-screen bg-[#fff] flex flex-col items-center justify-center">
        <el-empty :description="t('siteClose')" :image="img('static/resource/images/site/close.png')" image-size="200px" />
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: "container"
});

</script>

<style lang="scss" scoped></style>