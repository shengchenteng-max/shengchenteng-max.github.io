export default [
    {
        path: "/",
        component: () => import('~/app/pages/index.vue')
    },
    {
        path: "/app/index",
        component: () => import('~/app/pages/index.vue')
    },
    {
        path: "/auth/login",
        component: () => import('~/app/pages/auth/login.vue'),
        meta: {
            layout: "container"
        }
    },
    {
        path: "/auth/register",
        component: () => import('~/app/pages/auth/register.vue'),
        meta: {
            layout: "container"
        }
    },
    {
        path: "/auth/bind",
        component: () => import('~/app/pages/auth/bind.vue'),
        meta: {
            layout: "container"
        }
    },
    {
        path: "/auth/agreement",
        component: () => import('~/app/pages/auth/agreement.vue'),
        meta: {
            layout: "member"
        }
    },
    {
        path: "/app/auth/agreement",
        component: () => import('~/app/pages/auth/agreement.vue'),
        meta: {
            layout: "member"
        }
    },
    {
        path: "/app/member/center",
        component: () => import('~/app/pages/member/center.vue'),
        meta: {
            middleware: ["auth"],
            layout: "member"
        }
    },
    {
        path: "/app/member/balance",
        component: () => import('~/app/pages/member/balance.vue'),
        meta: {
            middleware: ["auth"],
            layout: "member"
        }
    },
    {
        path: "/app/member/point",
        component: () => import('~/app/pages/member/point.vue'),
        meta: {
            middleware: ["auth"],
            layout: "member"
        }
    },
    {
        path: "/site/close",
        component: () => import('~/app/pages/site/close.vue'),
        meta: {
            layout: "container"
        }
    }
]
