import AOS from 'aos';
import "aos/dist/aos.css";
export default defineNuxtPlugin((NuxtApp) => {
    AOS.init(); // 初始化
    NuxtApp.vueApp.use(AOS)
})
