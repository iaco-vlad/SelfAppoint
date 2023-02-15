import { createRouter, createWebHistory } from 'vue-router';
import PrivateRoutes from './private';
import PublicRoutes from './public';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        ...PrivateRoutes,
        ...PublicRoutes,
    ],
})

router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    const isAuthenticated = localStorage.getItem('user');

    if (requiresAuth && !isAuthenticated) {
        next('/login');
    } else {
        next();
    }
});

export default router;
