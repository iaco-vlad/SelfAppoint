const userRoutes = [
    {
        path: '/',
        name: 'user.profile',
        component: () => import('../Pages/Private/User/Profile.vue'),
        meta: { requiresAuth: true }
    },
    {
        path: '/events',
        name: 'user.events',
        component: () => import('../Pages/Private/User/Events.vue'),
        meta: { requiresAuth: true }
    },
    {
        path: '/services',
        name: 'user.services',
        component: () => import('../Pages/Private/User/Services.vue'),
        meta: { requiresAuth: true }
    },
];

export default [
    {
        path: '/user',
        name: 'user',
        component: () => import('../Pages/Private/User/Profile.vue'),
        meta: { requiresAuth: true },
        children: userRoutes,
    },
];
