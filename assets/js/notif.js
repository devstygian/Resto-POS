// ================= SMART PATH DETECTION =================
(function () {
    // Auto-detect base path
    const scripts = document.querySelectorAll('script[src*="notif.js"]');
    const scriptSrc = scripts[scripts.length - 1]?.src || '';
    const baseUrl = scriptSrc.includes('assets/js/notif.js')
        ? window.location.origin + '/assets/js/notif.js'
        : '';

    // Smart path based on current page
    let notifUrl;
    if (window.location.pathname.includes('/src/order/')) {
        notifUrl = './get_notifications.php'; // view.php
    } else if (window.location.pathname.includes('/src/')) {
        notifUrl = '../order/get_notifications.php'; // Other src pages
    } else {
        notifUrl = 'src/order/get_notifications.php'; // index.php, root
    }

    window.notifUrl = notifUrl;
    console.log('🔗 Using API:', window.notifUrl);

    window.lastCount = window.lastCount || 0;

    // ================= CORE FUNCTIONS (unchanged) =================
    function loadNotifications() {
        console.log('🔄 Polling →', window.notifUrl);

        fetch(window.notifUrl + '?t=' + Date.now(), { cache: 'no-cache' })
            .then(res => {
                console.log('📡 Status:', res.status, res.statusText);
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                return res.text();
            })
            .then(raw => {
                console.log('📄 Raw (first 50):', raw.substring(0, 50));
                const data = JSON.parse(raw);
                console.log('✅ Data:', data);
                updateUI(data);
            })
            .catch(err => {
                console.error('❌ Poll failed:', err);
            });
    }

    function updateUI(data) {
        const count = parseInt(data.count) || 0;

        // Multiple selector strategies
        const badge = document.querySelector('.notif-badge, #notifCount, #dashBadge');
        const container = document.querySelector('.notif-container, #notifContainer');

        if (badge) {
            badge.style.display = count > 0 ? 'flex' : 'none';
            badge.textContent = count;
        }

        if (container && count > window.lastCount) {
            const newOrders = count - window.lastCount;
            for (let i = 0; i < newOrders; i++) {
                setTimeout(() => createPopup(`New Order! (${count} pending)`, container), i * 200);
            }
        }

        window.lastCount = count;
    }

    function createPopup(message, container) {
        const notif = document.createElement('div');
        notif.className = 'notif-popup';
        notif.textContent = message;
        container.appendChild(notif);

        setTimeout(() => notif.classList.add('show'), 50);
        setTimeout(() => {
            notif.classList.remove('show');
            setTimeout(() => notif.remove(), 400);
        }, 4000);
    }

    // ================= AUTO-START EVERYWHERE =================
    ['DOMContentLoaded', 'load'].forEach(event => {
        document.addEventListener(event, () => {
            console.log(`🚀 ${event} - Starting notifications`);
            setTimeout(loadNotifications, 1000); // 1s delay

            // Poll every 3s
            setInterval(loadNotifications, 3000);
        });
    });

    // Manual test
    window.testNotifications = () => loadNotifications();
})();