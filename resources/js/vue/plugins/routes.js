import Vue from 'vue'
import Router from 'vue-router'
import Middlewares from '../middleware/'
Vue.use(Router)

let routes = [{
        path: '/admin/401',
        name: 'unauthorized',
        component: require('../views/401.vue').default
    }, {
        path: '/admin/login',
        name: 'authenticate',
        component: require('../views/auth/Login.vue').default,
        meta: {
            middleware: [Middlewares.guestAdmin]
        }
    },
    {
        path: '/admin/dashboard',
        name: 'rootadmin',
        component: require('../views/layouts/AdminLayout.vue').default,
        meta: {
            middleware: [Middlewares.authAdmin]
        },
        children: [{
                path: '/admin/dashboard',
                name: 'admin',
                component: require('../views/admin/Dashboard').default,
                meta: {
                    middleware: [Middlewares.authAdmin]
                },
            },
            {
                path: '/admin/dashboard/staff',
                name: 'staff',
                component: require('../views/admin/StaffTable').default,
                meta: {
                    middleware: [Middlewares.authAdmin]
                },
            },
            {
                path: '/admin/dashboard/credentials',
                name: 'credentials',
                component: require('../views/admin/Credentials').default,
                meta: {
                    middleware: [Middlewares.authAdmin]
                },
            },
            {
                path: '/admin/dashboard/articles',
                name: 'articles',
                component: require('../views/admin/Articles').default,
                meta: {
                    middleware: [Middlewares.authAdmin]
                },
            },
            {
                path: '/admin/dashboard/permissions',
                name: 'permissions',
                component: require('../views/admin/Permissions').default,
                meta: {
                    middleware: [Middlewares.authAdmin]
                },
            },
            {
                path: '/admin/dashboard/roles',
                name: 'roles',
                component: require('../views/admin/Roles').default,
                meta: {
                    middleware: [Middlewares.authAdmin]
                },
            },
            {
                path: '/admin/dashboard/workstations',
                name: 'workstations',
                component: require('../views/admin/Workstations').default,
                meta: {
                    middleware: [Middlewares.authAdmin]
                },
            },
            {
                path: '/admin/dashboard/workpositions',
                name: 'workpositions',
                component: require('../views/admin/Workpositions').default,
                meta: {
                    middleware: [Middlewares.authAdmin]
                },
            },
            {
                path: '/admin/dashboard/cities',
                name: 'cities',
                component: require('../views/admin/Cities').default,
                meta: {
                    middleware: [Middlewares.authAdmin]
                },
            },
            {
                path: '/admin/dashboard/districts',
                name: 'districts',
                component: require('../views/admin/Districts').default,
                meta: {
                    middleware: [Middlewares.authAdmin]
                },
            },
            {
                path: '/admin/dashboard/subsidiaries',
                name: 'subsidiaries',
                component: require('../views/admin/Subsidiaries').default,
                meta: {
                    middleware: [Middlewares.authAdmin]
                },
            },
            {
                path: '/admin/dashboard/offers',
                name: 'offers',
                component: require('../views/admin/Offers').default,
                meta: {
                    middleware: [Middlewares.authAdmin]
                },
            },
            {
                path: '/admin/dashboard/providers',
                name: 'providers',
                component: require('../views/admin/Providers').default,
                meta: {
                    middleware: [Middlewares.authAdmin]
                },
            },
            {
                path: '/admin/dashboard/categories',
                name: 'categories',
                component: require('../views/admin/Categories').default,
                meta: {
                    middleware: [Middlewares.authAdmin]
                },
            },
            {
                path: '/admin/dashboard/igvs',
                name: 'igvs',
                component: require('../views/admin/Igvs').default,
                meta: {
                    middleware: [Middlewares.authAdmin]
                },
            },
            {
                path: '/admin/dashboard/prooftypes',
                name: 'prooftypes',
                component: require('../views/admin/Prooftypes').default,
                meta: {
                    middleware: [Middlewares.authAdmin]
                },
            },
            {
                path: '/admin/dashboard/shelves',
                name: 'shelves',
                component: require('../views/admin/Shelves').default,
                meta: {
                    middleware: [Middlewares.authAdmin]
                },
            },
            {
                path: '/admin/dashboard/passport',
                name: 'passport',
                component: require('../views/admin/Passport').default,
                meta: {
                    middleware: [Middlewares.authAdmin]
                },
            },
            {
                path: '/admin/dashboard/dealers',
                name: 'dealers',
                component: require('../views/admin/Dealers').default,
                meta: {
                    middleware: [Middlewares.authAdmin]
                },
            },
            {
                path: '/admin/dashboard/concessions',
                name: 'consessions',
                component: require('../views/admin/Concessions').default,
                meta: {
                    middleware: [Middlewares.authAdmin]
                },
            },
            {
                path: '/admin/dashboard/sale',
                name: 'sale',
                component: require('../views/admin/Sale').default,
                meta: {
                    middleware: [Middlewares.authAdmin]
                },
            },
        ],
    },
    {
        path: '/dealer/login',
        name: 'authenticatedealer',
        component: require('../views/auth/DealerLogin.vue').default,
        meta: {
            middleware: [Middlewares.guestDealer]
        }
    },
    {
        path: '/dealer/dashboard',
        name: 'rootdealer',
        component: require('../views/layouts/DealerLayout.vue').default,
        meta: {
            middleware: [Middlewares.authDealer]
        },
        children: [{
                path: '/dealer/dashboard',
                name: 'dealer',
                component: require('../views/dealer/DealerDashboard').default,
                meta: {
                    middleware: [Middlewares.authDealer]
                },
            },
            {
                path: '/dealer/dashboard/articles',
                name: 'dealerarticles',
                component: require('../views/dealer/DealerArticles').default,
                meta: {
                    middleware: [Middlewares.authDealer]
                },
            },
            {
                path: '/dealer/dashboard/offers',
                name: 'dealeroffers',
                component: require('../views/dealer/DealerOffers').default,
                meta: {
                    middleware: [Middlewares.authDealer]
                },
            },
            {
                path: '/dealer/dashboard/providers',
                name: 'dealerproviders',
                component: require('../views/dealer/DealerProviders').default,
                meta: {
                    middleware: [Middlewares.authDealer]
                },
            },
            {
                path: '/dealer/dashboard/categories',
                name: 'dealercategories',
                component: require('../views/dealer/DealerCategories').default,
                meta: {
                    middleware: [Middlewares.authDealer]
                },
            },
        ],
    },
    {
        path: '/admin/*',
        component: require('../views/404.vue').default
    },
    {
        path: '/dealer/*',
        component: require('../views/404.vue').default
    },

]

const router = new Router({
    mode: 'history',
    routes: routes,
})

function nextCheck(context, middleware, index) {
    const nextMiddleware = middleware[index];
    if (!nextMiddleware) return context.next;

    return (...parameters) => {
        context.next(...parameters);
        const nextMidd = nextCheck(context, middleware, index + 1);

        nextMiddleware({...context, next: nextMidd });
    }
}

router.beforeEach((to, from, next) => {
    if (to.meta.middleware) {
        const middleware = Array.isArray(to.meta.middleware) ? to.meta.middleware : [to.meta.middleware];

        const context = {
            from,
            next,
            router,
            to
        }
        const nextMiddleware = nextCheck(context, middleware, 1);

        return middleware[0]({...context, next: nextMiddleware })
    }
    return next();
});

export default router