import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue'; // Atau bisa langsung di-mount ke #app
import router from './router';

const app = createApp(App);
app.use(router);
app.mount('#app');
