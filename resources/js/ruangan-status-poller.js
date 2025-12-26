/**
 * Real-Time Room Status Polling
 * 
 * File ini menyediakan JavaScript untuk:
 * 1. Polling status ruangan dari API
 * 2. Update UI secara real-time
 * 3. Menampilkan countdown waktu booking
 * 4. Handle auto-refresh status
 */

class RuanganStatusPoller {
    constructor(options = {}) {
        this.pollingInterval = options.pollingInterval || 5000; // 5 detik
        this.apiBaseUrl = options.apiBaseUrl || '/api/ruangan';
        this.statusElements = new Map(); // Map ruangan_id => DOM element
        this.timers = new Map(); // Map ruangan_id => timer id
        this.isRunning = false;
    }

    /**
     * Register ruangan element untuk di-monitor
     * @param {number} ruangan_id 
     * @param {HTMLElement} element - Element yang akan di-update status-nya
     */
    register(ruangan_id, element) {
        this.statusElements.set(ruangan_id, element);
    }

    /**
     * Mulai polling status
     */
    start() {
        if (this.isRunning) return;
        
        this.isRunning = true;
        console.log('[RuanganStatusPoller] Starting...');
        
        // Poll pertama kali
        this.pollAll();
        
        // Set interval untuk polling berulang
        setInterval(() => this.pollAll(), this.pollingInterval);
    }

    /**
     * Hentikan polling
     */
    stop() {
        this.isRunning = false;
        console.log('[RuanganStatusPoller] Stopped');
    }

    /**
     * Poll semua ruangan yang terdaftar
     */
    async pollAll() {
        if (this.statusElements.size === 0) return;

        const ruangan_ids = Array.from(this.statusElements.keys());
        
        try {
            const response = await fetch(`${this.apiBaseUrl}/status/bulk`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ ruangan_ids })
            });

            if (!response.ok) {
                console.error('[RuanganStatusPoller] API Error:', response.status);
                return;
            }

            const data = await response.json();
            
            // Update semua ruangan
            data.data.forEach(room => {
                this.updateRoomUI(room);
            });

        } catch (error) {
            console.error('[RuanganStatusPoller] Fetch Error:', error);
        }
    }

    /**
     * Poll status satu ruangan
     * @param {number} ruangan_id 
     */
    async pollSingle(ruangan_id) {
        try {
            const response = await fetch(`${this.apiBaseUrl}/${ruangan_id}/status`);
            
            if (!response.ok) {
                console.error('[RuanganStatusPoller] API Error:', response.status);
                return null;
            }

            const data = await response.json();
            this.updateRoomUI(data);
            return data;

        } catch (error) {
            console.error('[RuanganStatusPoller] Fetch Error:', error);
            return null;
        }
    }

    /**
     * Update UI dengan status room terbaru
     * @param {Object} roomData 
     */
    updateRoomUI(roomData) {
        const element = this.statusElements.get(roomData.ruangan_id);
        if (!element) return;

        const statusClass = `status-${roomData.status}`;
        const statusLabel = this.getStatusLabel(roomData.status);

        // Update status badge
        const statusBadge = element.querySelector('[data-status-badge]');
        if (statusBadge) {
            statusBadge.className = `badge ${statusClass}`;
            statusBadge.textContent = statusLabel;
        }

        // Update booking info
        if (roomData.current_booking) {
            this.updateBookingInfo(element, roomData.current_booking);
        } else {
            // Hapus booking info jika tidak ada yang aktif
            const bookingInfo = element.querySelector('[data-booking-info]');
            if (bookingInfo) {
                bookingInfo.style.display = 'none';
            }
        }
    }

    /**
     * Update informasi booking yang sedang berlangsung
     * @param {HTMLElement} element 
     * @param {Object} booking 
     */
    updateBookingInfo(element, booking) {
        let bookingInfo = element.querySelector('[data-booking-info]');
        
        if (!bookingInfo) {
            bookingInfo = document.createElement('div');
            bookingInfo.setAttribute('data-booking-info', '');
            bookingInfo.className = 'booking-info mt-2 p-2 bg-warning bg-opacity-10 rounded';
            element.appendChild(bookingInfo);
        }

        const endTime = new Date(booking.tanggal_jam_keluar);
        const now = new Date();
        const timeRemaining = Math.max(0, Math.floor((endTime - now) / 1000));

        const timeStr = this.formatTimeRemaining(timeRemaining);

        bookingInfo.innerHTML = `
            <small class="d-block"><strong>Dipinjam oleh:</strong> ${booking.user_name}</small>
            <small class="d-block"><strong>Dosen:</strong> ${booking.dosen_pengampu}</small>
            <small class="d-block text-warning"><strong>Selesai dalam:</strong> ${timeStr}</small>
        `;
        bookingInfo.style.display = 'block';

        // Update countdown setiap detik
        clearInterval(this.timers.get(booking.id));
        const timer = setInterval(() => {
            const newEndTime = new Date(booking.tanggal_jam_keluar);
            const newNow = new Date();
            const newTimeRemaining = Math.max(0, Math.floor((newEndTime - newNow) / 1000));
            
            const newTimeStr = this.formatTimeRemaining(newTimeRemaining);
            const timeElement = bookingInfo.querySelector('small:last-child');
            
            if (timeElement) {
                timeElement.innerHTML = `<strong>Selesai dalam:</strong> ${newTimeStr}`;
            }

            // Jika waktu habis, clear countdown
            if (newTimeRemaining <= 0) {
                clearInterval(timer);
                bookingInfo.style.display = 'none';
                // Re-poll untuk refresh status
                const ruangan_id = element.getAttribute('data-ruangan-id');
                this.pollSingle(ruangan_id);
            }
        }, 1000);

        this.timers.set(booking.id, timer);
    }

    /**
     * Format waktu tersisa menjadi string readable
     * @param {number} seconds 
     * @returns {string}
     */
    formatTimeRemaining(seconds) {
        if (seconds <= 0) return 'Selesai';

        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        const secs = seconds % 60;

        const parts = [];
        if (hours > 0) parts.push(`${hours}j`);
        if (minutes > 0) parts.push(`${minutes}m`);
        if (secs > 0 || parts.length === 0) parts.push(`${secs}d`);

        return parts.join(' ');
    }

    /**
     * Get label untuk status dalam bahasa Indonesia
     * @param {string} status 
     * @returns {string}
     */
    getStatusLabel(status) {
        const labels = {
            'tersedia': '✓ Tersedia',
            'tidak_tersedia': '✗ Tidak Tersedia',
            'tidak_dapat_dipakai': '⚠ Tidak Dapat Dipakai'
        };
        return labels[status] || status;
    }

    /**
     * Get CSS class untuk status
     * @param {string} status 
     * @returns {string}
     */
    getStatusClass(status) {
        const classes = {
            'tersedia': 'bg-success',
            'tidak_tersedia': 'bg-danger',
            'tidak_dapat_dipakai': 'bg-warning'
        };
        return classes[status] || 'bg-secondary';
    }
}

/**
 * Helper: Check ketersediaan ruangan untuk slot waktu tertentu
 */
async function checkAvailableRooms(tanggal, jam_mulai, jam_selesai) {
    try {
        const params = new URLSearchParams({
            tanggal,
            jam_mulai,
            jam_selesai
        });

        const response = await fetch(`/api/ruangan/available?${params}`);
        
        if (!response.ok) {
            console.error('API Error:', response.status);
            return [];
        }

        const data = await response.json();
        return data.available_rooms;

    } catch (error) {
        console.error('Fetch Error:', error);
        return [];
    }
}

/**
 * Initialize pada DOM ready
 */
document.addEventListener('DOMContentLoaded', function() {
    // Auto-initialize poller untuk semua ruangan di halaman
    const poller = new RuanganStatusPoller({
        pollingInterval: 5000, // 5 detik
        apiBaseUrl: '/api/ruangan'
    });

    // Register semua ruangan elements
    document.querySelectorAll('[data-ruangan-id]').forEach(element => {
        const ruangan_id = element.getAttribute('data-ruangan-id');
        poller.register(ruangan_id, element);
    });

    // Mulai polling
    if (poller.statusElements.size > 0) {
        poller.start();
    }

    // Expose ke global scope untuk manual control
    window.RuanganStatusPoller = RuanganStatusPoller;
    window.checkAvailableRooms = checkAvailableRooms;
});
