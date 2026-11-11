import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import AdminDashboard from '../views/AdminDashboard.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/admin',
    name: 'admin.dashboard',
    component: AdminDashboard,
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem('auth_token');
      const userData = localStorage.getItem('user_data');

      // Coba parse user_data
      let user = null;
      try {
        user = userData ? JSON.parse(userData) : null;
      } catch (e) {
        console.error('Error parsing user_data:', e);
      }

      console.log('Debug Auth Admin:', { token, user });

      if (!token || !user) {
        alert('Silakan login terlebih dahulu!');
        return next({ name: 'home' });
      }

      const roles = user.roles ? user.roles.toLowerCase() : '';
      if (['admin', 'guru', 'staff'].includes(roles)) {
        return next(); // Izinkan masuk
      } else {
        alert('Akses ditolak! Anda bukan Admin/Guru/Staff.');
        return next({ name: 'home' });
      }
    }
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
