/**
 * Finject Real-Time Intelligence Engine
 * Handles background polling and live UI updates.
 */

class FinjectRealtime {
    constructor(pollInterval = 5000) {
        this.pollInterval = pollInterval;
        this.isPolling = false;
        this.lastNotificationCount = null;
        this.lastRequestId = null;
        this.supportFingerprint = null;
        
        // Base URL helper (ensure it matches project root)
        this.baseUrl = window.location.pathname.split('/')[1];
        if (this.baseUrl === 'User' || this.baseUrl === 'Admin') {
            this.baseUrl = ''; // If we are at root
        } else {
            this.baseUrl = '/' + this.baseUrl;
        }
        
        this.init();
    }

    init() {
        console.log('Real-Time Engine Initialized');
        this.startPolling();
        
        // Global Mark All Read event
        window.markAllRead = async () => {
            try {
                const response = await fetch(`${this.baseUrl}/Shared/mark-all-read`);
                if (response.ok) {
                    this.updateNotificationUI({ unread_count: 0, recent: [] });
                }
            } catch (err) {
                console.error('Failed to mark notifications as read', err);
            }
        };
    }

    startPolling() {
        if (this.isPolling) return;
        this.isPolling = true;
        this.poll();
    }

    async poll() {
        try {
            const response = await fetch(`${this.baseUrl}/Shared/poll`);
            if (response.ok) {
                const data = await response.json();
                if (!data.error) {
                    this.processUpdates(data);
                }
            }
        } catch (err) {
            console.error('Polling error:', err);
        } finally {
            setTimeout(() => this.poll(), this.pollInterval);
        }
    }

    processUpdates(data) {
        // 1. Update Notifications
        this.updateNotificationUI(data.notifications);

        // 2. Update Stats (Dashboard)
        this.updateStatsUI(data.stats);

        // 3. Handle Support/Messaging Refresh
        if (data.stats.last_request_id && this.lastRequestId !== null && data.stats.last_request_id !== this.lastRequestId) {
            this.refreshSupportUI('admin');
        }
        if (data.stats.support_fingerprint && this.supportFingerprint !== null && data.stats.support_fingerprint !== this.supportFingerprint) {
            this.refreshSupportUI('user');
        }

        // Update state
        this.lastRequestId = data.stats.last_request_id || this.lastRequestId;
        this.supportFingerprint = data.stats.support_fingerprint || this.supportFingerprint;

        // 4. Trigger specific page events
        window.dispatchEvent(new CustomEvent('finjectUpdate', { detail: data }));
    }

    async refreshSupportUI(context) {
        console.log('Refreshing support UI context:', context);
        const container = document.querySelector('[data-realtime-container="support-list"]');
        if (!container) return;

        try {
            // We fetch the current page HTML but only extract the list part
            const response = await fetch(window.location.href);
            if (response.ok) {
                const html = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newList = doc.querySelector('[data-realtime-container="support-list"]');
                if (newList) {
                    container.innerHTML = newList.innerHTML;
                    lucide.createIcons(); // Re-init icons
                    
                    // Visual feedback
                    container.classList.add('animate-pulse-quick');
                    setTimeout(() => container.classList.remove('animate-pulse-quick'), 500);
                }
            }
        } catch (err) {
            console.error('Failed to refresh support list', err);
        }
    }

    updateNotificationUI(notifs) {
        const badge = document.querySelector('.bell-badge'); // We need to add this class in header
        const dropdown = document.querySelector('.notification-dropdown-list');
        const countText = document.querySelector('.notification-count-text');

        // Update Badge
        if (badge) {
            if (notifs.unread_count > 0) {
                badge.classList.remove('hidden');
                if (this.lastNotificationCount !== null && notifs.unread_count > this.lastNotificationCount) {
                    this.playNotificationSound();
                    badge.classList.add('animate-ping');
                    setTimeout(() => badge.classList.remove('animate-ping'), 1000);
                }
            } else {
                badge.classList.add('hidden');
            }
        }

        // Update Dropdown List
        if (dropdown && notifs.recent) {
            if (notifs.recent.length === 0) {
                dropdown.innerHTML = `
                    <div class="text-center py-8">
                        <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">No New Intelligence</p>
                    </div>
                `;
            } else {
                const html = notifs.recent.map(n => {
                    const link = n.link ? (n.link.startsWith('http') ? n.link : `${this.baseUrl}/${n.link.replace(/^\//, '')}`) : '#';
                    return `
                        <a href="${link}" class="block p-3 rounded-2xl hover:bg-white/5 border border-transparent hover:border-white/5 transition-all group/item">
                            <p class="text-sm font-bold text-slate-200 mb-1 group-hover/item:text-indigo-400 font-inter">${n.title}</p>
                            <p class="text-[11px] text-slate-500 leading-relaxed line-clamp-2">${n.message}</p>
                        </a>
                    `;
                }).join('');
                dropdown.innerHTML = html;
            }
        }

        if (countText) countText.innerText = notifs.unread_count + ' Unread';
        
        this.lastNotificationCount = notifs.unread_count;
    }

    updateStatsUI(stats) {
        // Update elements with data-stat attribute
        for (const [key, value] of Object.entries(stats)) {
            const elements = document.querySelectorAll(`[data-stat="${key}"]`);
            elements.forEach(el => {
                const currentVal = el.innerText.replace(/[$,\s]/g, '');
                if (parseFloat(currentVal) !== parseFloat(value)) {
                    el.classList.add('text-indigo-400', 'scale-110');
                    el.innerText = this.formatValue(key, value);
                    setTimeout(() => el.classList.remove('text-indigo-400', 'scale-110'), 2000);
                }
            });
        }
    }

    formatValue(key, value) {
        if (key.includes('total') || key.includes('amount')) {
            return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(value);
        }
        return value;
    }

    playNotificationSound() {
        // Optional: Add a subtle ping sound
        // const audio = new Audio('/assets/sounds/notify.mp3');
        // audio.play().catch(() => {});
    }
}

// Start Engine
document.addEventListener('DOMContentLoaded', () => {
    window.FinjectRT = new FinjectRealtime();
});
