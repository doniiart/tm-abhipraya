// Tunggu sampai ada notifikasi masuk dari server
self.addEventListener('push', function (e) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        return;
    }

    // Ambil data pesan (judul dan isi) yang dikirim dari Laravel
    var data = e.data.json();

    // Tampilkan notifikasinya di layar HP
    e.waitUntil(
        self.registration.showNotification(data.title, {
            body: data.body,
            icon: '/logo.png',
            badge: '/logo.png', // Ikon kecil di status bar atas HP
            data: {
                url: data.action_url // Link kalau notifnya diklik
            }
        })
    );
});

// Aksi kalau anggota mengklik / nge-tap notifikasinya
self.addEventListener('notificationclick', function (e) {
    e.notification.close(); // Tutup notifnya
    e.waitUntil(
        clients.openWindow(e.notification.data.url) // Arahkan ke halaman detail kumpulan
    );
});