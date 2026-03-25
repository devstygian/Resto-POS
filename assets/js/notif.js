(() => {
    let lastCount = 0;

    const notifUrl = '/Nadine-system/src/notification/get_notifications.php';
    const orderUrl = '/Nadine-system/src/notification/get_orders.php';
    const dashboardUrl = '/Nadine-system/src/dashboard/get_dashboard.php'; // you will create this

    /* NOTIFICATIONS (GLOBAL)*/
    function loadNotifications() {
        fetch(notifUrl + '?t=' + Date.now())
            .then(res => res.json())
            .then(data => {
                const count = parseInt(data.count) || 0;

                const badge = document.querySelector('.notif-badge');
                const container = document.querySelector('.notif-container');

                if (badge) {
                    badge.style.display = count > 0 ? 'flex' : 'none';
                    badge.textContent = count;
                }

                // Show popup only if NEW orders
                if (count > lastCount && container) {
                    createPopup(`New Order! (${count} pending)`, container);
                }

                lastCount = count;
            })
            .catch(err => console.error('Notif error:', err));
    }

    /*  VIEW.PHP (ORDERS GRID)*/
    function loadOrders() {
        const container = document.getElementById('ordersContainer');
        if (!container) return; // only runs on view.php

        fetch(orderUrl + '?t=' + Date.now())
            .then(res => res.text())
            .then(html => {
                container.innerHTML = html;
            })
            .catch(err => console.error('Orders error:', err));
    }

    /* Dashboard
    function loadDashboard() {
        const dashboard = document.getElementById('dashboardContainer');
        if (!dashboard) return; // only runs on dashboard

        fetch(dashboardUrl + '?t=' + Date.now())
            .then(res => res.text())
            .then(html => {
                dashboard.innerHTML = html;
            })
            .catch(err => console.error('Dashboard error:', err));
    }

    /* POPUP */
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

    /*AUTO REFRESH ENGINE*/
    function startAutoRefresh() {
        setInterval(() => {
            loadNotifications(); // always runs
            loadOrders();        // only if view.php
            //loadDashboard();     // only if index.php
        }, 5000);

        // Refresh instantly when user returns
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) {
                loadNotifications();
                loadOrders();
                //loadDashboard();
            }
        });
    }

    /* INIT*/
    document.addEventListener('DOMContentLoaded', () => {
        loadNotifications();
        loadOrders();
        //loadDashboard();
        startAutoRefresh();
    });

})();