/**
 * 获取验证码
 */
export function getCaptcha() {
    return request.get('captcha', { time: (new Date().getTime()) })
}

/**
 * 获取微信公众号授权码
 */
export function getWechatAuthCode(data: AnyObject) {
    return request.get('wechat/codeurl', data)
}

/**
 * 同步微信信息
 */
export function wechatSync(data: AnyObject) {
    return request.get('wechat/sync', data)
}

/**
 * 获取协议信息
 */
export function getAgreementInfo(key: string) {
    return request.get(`agreement/${ key }`)
}

/**
 * 重置密码
 */
export function resetPassword(data: AnyObject) {
    return request.post(`password/reset`, data)
}

/**
 * 发送短信验证码
 */
export function sendSms(data: AnyObject) {
    return request.post(`send/mobile/${ data.type }`, data)
}

/**
 * 获取微信jssdk config
 */
export function getWechatSkdConfig(data: AnyObject) {
    return request.get('wechat/jssdkconfig', data)
}

/**
 * 拉取图片
 */
export function fetchImage(data: AnyObject) {
    return request.post('file/image/fetch', data)
}

/**
 * 拉取base64图片
 */
export function fetchBase64Image(data: AnyObject) {
    return request.post('file/image/base64', data)
}

/**
 * 获取版权信息
 */
export function getCopyRight() {
    return request.get('copyright')
}

/**
 * 获取站点信息
 */
export function getSiteInfo() {
    return request.get('site')
}
/**
 * 获取广告位
 */
export function getAdvInfo(params: Record<string, any>) {
    return request.get(`web/adv`, params, { showErrorMessage: false })
}

/**
 * 获取导航列表
 */
export function getNavList() {
    return request.get(`web/nav`)
}

/**
 * 获取友情链接
 */
export function getFriendlyLink() {
    return request.get(`web/friendly_link`)
}
