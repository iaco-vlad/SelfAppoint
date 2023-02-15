export default [
    {
        path: '/login',
        name: 'login',
        component: () => import('../Pages/Public/Login.vue')
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('../Pages/Public/Register.vue')
    },
    {
        path: '/new-appointment',
        name: 'new-appointment',
        component: () => import('../Pages/Public/NewAppointment.vue')
    },
    {
        path: '/',
        name: 'home',
        component: () => import('../Pages/Public/Home.vue')
    }
];
