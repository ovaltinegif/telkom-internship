import './bootstrap';

import AOS from 'aos';
import 'aos/dist/aos.css';
import intersect from '@alpinejs/intersect';
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
window.Swal = Swal.mixin({
    customClass: {
        popup: 'dark:bg-slate-900 dark:border-slate-800 dark:text-slate-200 border rounded-2xl shadow-xl',
        title: 'dark:text-slate-100',
        htmlContainer: 'dark:text-slate-400',
        confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg px-4 py-2 transition',
        cancelButton: 'bg-gray-300 hover:bg-gray-400 dark:bg-slate-700 dark:hover:bg-slate-600 dark:text-slate-200 text-gray-800 font-semibold rounded-lg px-4 py-2 transition ml-2',
    },
    buttonsStyling: false
});

Alpine.plugin(intersect);
Alpine.start();

import "@hotwired/turbo";

// Re-initialize AOS on every Turbo page load
document.addEventListener("turbo:load", function () {
    AOS.init({
        duration: 800,
        once: true,
    });
});
