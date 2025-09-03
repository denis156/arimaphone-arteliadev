import axios from 'axios';
import AOS from 'aos';
import 'aos/dist/aos.css';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

AOS.init();
