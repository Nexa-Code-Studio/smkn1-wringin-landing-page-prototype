import './bootstrap';
import Alpine from 'alpinejs';

import Chart from 'chart.js/auto';
import confetti from 'canvas-confetti';
window.Chart = Chart;
window.confetti = confetti;
window.Alpine = Alpine;
Alpine.start();

// ===== Scroll-Triggered Animations =====
// Replays animations when elements re-enter the viewport
document.addEventListener('DOMContentLoaded', () => {
    const animatedElements = document.querySelectorAll('[data-animate]');

    if (!animatedElements.length) return;

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                } else {
                    // Remove class so animation replays on re-enter
                    entry.target.classList.remove('is-visible');
                }
            });
        },
        {
            threshold: 0.15,
            rootMargin: '0px 0px -50px 0px',
        }
    );

    animatedElements.forEach((el) => observer.observe(el));
});
