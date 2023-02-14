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
    if (to.matched.some(record => record.meta.requiresAuth) && !isAuthenticated()) {
        next('/login');
    } else {
        next();
    }
});

export default router;