import axios from 'axios';
window.axios = axios;

import { client } from 'laravel-precognition-vue-inertia';

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

client.use(window.axios);
