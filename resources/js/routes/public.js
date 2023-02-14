export default [
    {
        path: '/login',
        component: () => import('../Pages/Public/Login.vue')
    },
    {
        path: '/register',
        component: () => import('../Pages/Public/Register.vue')
    },
    // {
    //     path: '/new-appointment',
    //     component: () => import('../API/Public/NewAppointment.vue')
    // },
    // {
    //     path: '/home',
    //     component: () => import('../API/Public/Home.vue')
    // }
];
