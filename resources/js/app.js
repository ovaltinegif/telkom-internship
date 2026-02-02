import './bootstrap';

import AOS from 'aos';
import 'aos/dist/aos.css';
import intersect from '@alpinejs/intersect';
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
window.Swal = Swal;

Alpine.plugin(intersect);
Alpine.start();
AOS.init();
