document.addEventListener('DOMContentLoaded', () => {
    // 1. Menú Hamburguesa Mobile
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.3
    };

    const animateIndicators = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const svgCircle = entry.target.querySelector('path[stroke-dasharray]');
                if (svgCircle) {
                    const dashArray = svgCircle.getAttribute('stroke-dasharray');
                    // Reinicia animación para efecto visual dinámico
                    svgCircle.style.transition = 'stroke-dasharray 1.5s ease-in-out';
                    svgCircle.setAttribute('stroke-dasharray', dashArray);
                }
                observer.unobserve(entry.target);
            }
        });
    };

    const observer = new IntersectionObserver(animateIndicators, observerOptions);
    const indicatorItems = document.querySelectorAll('#nosotros li, section ul li');

    indicatorItems.forEach(item => {
        if (item.querySelector('svg')) {
            observer.observe(item);
        }
    });

});