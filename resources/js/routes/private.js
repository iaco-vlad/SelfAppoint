export default [
    {
        path: '/profile',
        component: () => import('../Pages/Private/Profile.vue'),
        meta: { requiresAuth: true }
    },
    {
        path: '/events',
        component: () => import('../Pages/Private/Events.vue'),
        meta: { requiresAuth: true }
    },
    {
        path: '/services',
        component: () => import('../Pages/Private/Services.vue'),
        meta: { requiresAuth: true }
    },
];