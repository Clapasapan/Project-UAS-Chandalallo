---

## 🔍 Penjelasan Setiap Fitur dan Kegunaannya

### 🔐 Autentikasi (Login & Register)

- **`login.php`** — Form login untuk admin. Mengecek data dari tabel `users`. Jika berhasil, diarahkan ke dashboard admin.
- **`register.php`** — Digunakan untuk mendaftarkan admin baru. Data disimpan di tabel `users` dengan password yang dienkripsi.
- **`login_pembeli.php`** — Form login untuk pembeli. Memeriksa email dan password dari tabel `pelanggan`.
- **`register_pembeli.php`** — Form pendaftaran akun pembeli. Setelah berhasil, pembeli bisa langsung login ke sistem.

---

### 🛒 Fitur Pembeli

- **`pembeli/index.php`** — Halaman utama pembeli. Menampilkan semua produk yang tersedia.
- **`pembeli/produk.php`** — Menampilkan detail lengkap produk berdasarkan ID.
- **`pembeli/beli.php`** — Halaman form pembelian. Pembeli mengisi jumlah produk yang akan dibeli.
- **`pembeli/checkout.php`** — Menyimpan transaksi dan detailnya ke database. Menghitung total dan mencatat waktu pembelian.
- **`pembeli/sukses.php`** — Menampilkan struk atau bukti pembelian setelah transaksi berhasil.
- **`pembeli/transaksi.php`** — Menampilkan riwayat transaksi pembeli, termasuk total dan statusnya.

---

### 👨‍💼 Fitur Admin

- **`dashboard.php`** — Berisi ringkasan data seperti jumlah produk dan transaksi. Halaman utama admin setelah login.
- **`admin_produk/`** — Modul untuk melihat, menambah, mengedit, dan menghapus produk. Data tersimpan di tabel `produk`.
- **`admin_user/`** — Modul untuk mengelola akun admin: tambah, edit, dan hapus user.
- **`admin_kategori/`** *(jika ada)* — Untuk mengelompokkan produk berdasarkan kategori.
- **`admin_aktivitas/`** *(jika ada)* — Melacak aktivitas yang dilakukan oleh admin.

---

### ⚙️ Lain-lain

- **`includes/db.php`** — File koneksi ke database. Dipanggil di hampir semua file.
- **`uploads/`** — Folder penyimpanan gambar produk yang diunggah oleh admin.
- **`preloved_store.sql`** — File SQL untuk membuat seluruh tabel yang dibutuhkan dalam sistem:
  - `users` (admin)
  - `pelanggan` (pembeli)
  - `produk` (barang)
  - `transaksi` (data pembelian)
  - `transaksi_detail` (rincian pembelian)

---

