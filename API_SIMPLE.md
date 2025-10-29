# API Kasir Restoran - Simple

## Login
```
POST /login
{
    "email": "admin@resto.com",
    "password": "password"
}
```

## Admin - Kelola Meja
```
GET    /admin/           - Lihat semua meja
POST   /admin/meja       - Tambah meja baru
PUT    /admin/meja/{id}  - Update meja
DELETE /admin/meja/{id}  - Hapus meja
```

## Waiter - Kelola Menu & Pesanan
```
GET    /waiter/              - Lihat semua pesanan
GET    /waiter/menu          - Lihat semua menu
POST   /waiter/menu          - Tambah menu baru
PUT    /waiter/menu/{id}     - Update menu
POST   /waiter/pesanan       - Buat pesanan baru
PUT    /waiter/pesanan/{id}  - Update pesanan
GET    /waiter/meja-kosong   - Lihat meja kosong
GET    /waiter/pelanggan     - Lihat semua pelanggan
POST   /waiter/pelanggan     - Tambah pelanggan baru
PUT    /waiter/pelanggan/{id} - Update pelanggan
DELETE /waiter/pelanggan/{id} - Hapus pelanggan
```

## Kasir - Kelola Transaksi
```
GET    /kasir/                    - Lihat semua transaksi
POST   /kasir/transaksi           - Proses pembayaran
GET    /kasir/pesanan-siap-bayar  - Lihat pesanan siap bayar
GET    /kasir/hari-ini            - Lihat transaksi hari ini
```

## Owner - Dashboard
```
GET    /owner/  - Lihat pendapatan hari ini
```

## Logout
```
POST /logout
```

## Contoh Request

### Tambah Meja
```
POST /admin/meja
{
    "nomormeja": "A1",
    "kapasitas": 4
}
```

### Tambah Menu
```
POST /waiter/menu
{
    "namamenu": "Nasi Goreng",
    "harga": 15000
}
```

### Tambah Pelanggan
```
POST /waiter/pelanggan
{
    "namapelanggan": "John Doe",
    "jeniskelamin": true,
    "noip": "081234567890",
    "alamat": "Jl. Contoh No. 123"
}
```

### Buat Pesanan
```
POST /waiter/pesanan
{
    "idmeja": 1,
    "idpelanggan": 1,
    "total": 30000,
    "items": [
        {
            "idmenu": 1,
            "jumlah": 2,
            "harga": 15000,
            "subtotal": 30000
        }
    ]
}
```

## Database Schema
- **Pelanggan**: idpelanggan, namapelanggan, jeniskelamin, noip, alamat
- **Meja**: idmeja, nomormeja, kapasitas, status (kosong/terisi/maintenance)
- **Menu**: idmenu, namamenu, harga, aktif
- **Pesanan**: idpesanan, idmeja, iduser_waiter, idpelanggan, status (pending/proses/selesai/lunas), total
- **PesananDetail**: iddetail, idpesanan, idmenu, jumlah, harga, subtotal, status_item
- **Transaksi**: idtransaksi, idpesanan, idkasir, total, bayar, kembali, metode_pembayaran

### Proses Pembayaran
```
POST /kasir/transaksi
{
    "idpesanan": 1,
    "total": 30000,
    "bayar": 35000,
    "metode_pembayaran": "cash"
}
```

## Header yang Diperlukan
```
Authorization: Bearer {token}
Content-Type: application/json
```
