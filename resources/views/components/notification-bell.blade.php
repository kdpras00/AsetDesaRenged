<div class="relative ml-3">
    <!-- Bell Button -->
    <button type="button" id="notification-btn" class="relative p-2 text-gray-500 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">View notifications</span>
        <!-- Bell Icon -->
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        <!-- Red Badge -->
        <div id="notification-badge" class="hidden absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full dark:border-gray-900">
            0
        </div>
    </button>

    <!-- Dropdown Menu -->
    <div id="notification-dropdown" class="hidden absolute right-0 z-50 w-80 mt-2 bg-white rounded-lg shadow-xl overflow-hidden border border-gray-100 dark:bg-gray-800 dark:border-gray-700 origin-top-right transition-transform duration-200 ease-out scale-95 opacity-0">
        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-900">
            <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">Notifikasi</span>
            <button id="mark-all-read" class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 hover:underline">Tandai semua dibaca</button>
        </div>
        <ul id="notification-list" class="max-h-64 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-700">
            <!-- Items loaded via JS -->
            <li class="px-4 py-3 text-center text-sm text-gray-500 dark:text-gray-400">Memuat...</li>
        </ul>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('notification-btn');
        const dropdown = document.getElementById('notification-dropdown');
        const badge = document.getElementById('notification-badge');
        const list = document.getElementById('notification-list');
        const markAllBtn = document.getElementById('mark-all-read');
        let isOpen = false;

        // Toggle Dropdown
        if (btn && dropdown) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                isOpen = !isOpen;
                if (isOpen) {
                    dropdown.classList.remove('hidden');
                    // Small delay to allow display:block to apply before opacity transition
                    requestAnimationFrame(() => {
                        dropdown.classList.remove('scale-95', 'opacity-0');
                        dropdown.classList.add('scale-100', 'opacity-100');
                    });
                    fetchNotifications();
                } else {
                    closeDropdown();
                }
            });

            // Close on click outside
            document.addEventListener('click', function(e) {
                if (isOpen && !btn.contains(e.target) && !dropdown.contains(e.target)) {
                    closeDropdown();
                }
            });
        }

        function closeDropdown() {
            isOpen = false;
            dropdown.classList.remove('scale-100', 'opacity-100');
            dropdown.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                dropdown.classList.add('hidden');
            }, 200);
        }

        // Polling Count (Every 30s)
        function checkUnread() {
            if (!badge) return;
            
            fetch("{{ route('notifications.count') }}?t=" + new Date().getTime())
                .then(res => {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.json();
                })
                .then(data => {
                    if (data.count > 0) {
                        badge.textContent = data.count > 99 ? '99+' : data.count;
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                })
                .catch(err => {
                    // Silent fail for background polling to avoid console spam
                });
        }

        // Initial Check & Interval
        checkUnread();
        setInterval(checkUnread, 30000);

        // Fetch List
        function fetchNotifications() {
            if (!list) return;

            list.innerHTML = '<li class="px-4 py-3 text-center text-sm text-gray-500 dark:text-gray-400">Memuat...</li>';

            fetch("{{ route('notifications.index') }}?t=" + new Date().getTime())
                .then(res => {
                    if (!res.ok) throw new Error('Failed to fetch notifications');
                    return res.json();
                })
                .then(data => {
                    list.innerHTML = '';
                    if (!Array.isArray(data) || data.length === 0) {
                        list.innerHTML = '<li class="px-4 py-3 text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada notifikasi</li>';
                        return;
                    }

                    data.forEach(item => {
                        const li = document.createElement('li');
                        const isUnread = !item.read_at;
                        const bgColor = isUnread ? 'bg-blue-50 dark:bg-blue-900/20' : 'bg-white dark:bg-gray-800';
                        
                        // Parse data
                        const notifData = item.data || {};
                        const message = notifData.message || 'Notification';
                        const url = notifData.url || '#';
                        const type = notifData.type || 'info';
                        
                        const iconColor = type === 'danger' ? 'text-red-500' : (type === 'warning' ? 'text-yellow-500' : 'text-blue-500');

                        li.className = `${bgColor} px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition cursor-pointer border-b border-gray-100 dark:border-gray-700 last:border-0`;
                        li.innerHTML = `
                            <div class="flex items-start space-x-3">
                                <span class="${iconColor} mt-1.5 text-[10px]">●</span>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white leading-snug">${message}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">${timeSince(new Date(item.created_at))}</p>
                                </div>
                            </div>
                        `;
                        
                        li.addEventListener('click', (e) => {
                            e.preventDefault(); // Prevent default if it was a link
                            e.stopPropagation(); // Prevent closing dropdown immediately if logic requires
                            
                            // Show loading indicator on the item
                            li.classList.add('opacity-50', 'pointer-events-none');
                            
                            // Mark as read and redirect
                            markAsRead(item.id, url);
                        });

                        list.appendChild(li);
                    });
                })
                .catch(err => {
                    console.error('Error fetching notifications:', err);
                    list.innerHTML = '<li class="px-4 py-3 text-center text-sm text-red-500">Gagal memuat notifikasi</li>';
                });
        }

        // Mark single as read
        function markAsRead(id, url) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error('CSRF token not found');
                if (url && url !== '#') window.location.href = url;
                return;
            }

            fetch(`/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken.content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) console.warn('Mark as read backend error');
                return res.json().catch(() => ({}));
            })
            .then(() => {
                // Determine destination
                if (url && url !== '#') {
                    // Use window.location.replace to adhere to SPA/Standard navigation
                    window.location.href = url;
                } else {
                    // Update UI if no redirect
                    checkUnread();
                    fetchNotifications();
                }
            })
            .catch(err => {
                console.error('Error marking as read:', err);
                // Fallback redirect even on error
                if (url && url !== '#') window.location.href = url;
            });
        }

        // Mark all as read
        if (markAllBtn) {
            markAllBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // UX Feedback
                const originalText = markAllBtn.textContent;
                markAllBtn.textContent = 'Memproses...';
                markAllBtn.disabled = true;
                markAllBtn.classList.add('opacity-75', 'cursor-not-allowed');

                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                     alert('Security token error. Please refresh the page.');
                     resetBtn();
                     return;
                }

                fetch("{{ route('notifications.readAll') }}", {
                     method: 'POST',
                     headers: {
                        'X-CSRF-TOKEN': csrfToken.content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(res => {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.json();
                })
                .then(data => {
                    // Optimistic UI updates
                    if (badge) badge.classList.add('hidden');
                    
                    // Reload list
                    fetchNotifications();
                    checkUnread();
                    
                    // Show success toast if Swal available
                    if (typeof Swal !== 'undefined') {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                        Toast.fire({
                            icon: 'success',
                            title: 'Semua notifikasi ditandai sudah dibaca'
                        });
                    }
                })
                .catch(err => {
                    console.error('Error marking all as read:', err);
                    alert('Gagal memproses permintaan. Silakan coba lagi.');
                })
                .finally(() => {
                    resetBtn();
                });

                function resetBtn() {
                    markAllBtn.textContent = originalText;
                    markAllBtn.disabled = false;
                    markAllBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                }
            });
        }

        // Time helper
        function timeSince(date) {
            const seconds = Math.floor((new Date() - date) / 1000);
            let interval = seconds / 31536000;
            if (interval > 1) return Math.floor(interval) + " thn lalu";
            interval = seconds / 2592000;
            if (interval > 1) return Math.floor(interval) + " bln lalu";
            interval = seconds / 86400;
            if (interval > 1) return Math.floor(interval) + " hari lalu";
            interval = seconds / 3600;
            if (interval > 1) return Math.floor(interval) + " jam lalu";
            interval = seconds / 60;
            if (interval > 1) return Math.floor(interval) + " mnt lalu";
            return "Baru saja";
        }
    });
</script>
