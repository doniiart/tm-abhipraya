<!-- Tombol untuk mengaktifkan notifikasi -->
<button id="tombol-notif" class="bg-yellow-400 text-green-900 px-4 py-2 rounded font-bold">
    🔔 Aktifkan Pengingat di HP
</button>

<script>
// Menangkap aksi ketika tombol diklik
document.getElementById('tombol-notif').addEventListener('click', function() {
    // Meminta izin ke browser / HP pengguna
    Notification.requestPermission().then(function(izin) {
        if (izin === 'granted') {
            alert('Mantap! Anda akan menerima pengingat kumpulan di HP ini.');
            // Catatan: Di sinilah nanti kode untuk menyimpan ID HP anggota ke database bekerja
        } else {
            alert('Izin ditolak. Anda bisa melihat jadwal di halaman Beranda.');
        }
    });
});
</script>