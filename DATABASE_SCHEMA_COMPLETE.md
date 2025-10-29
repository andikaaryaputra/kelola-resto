# Database Schema - Restaurant Cashier System

## ✅ **Database Tables Created**

### 1. **Pelanggan** (Customer)
```sql
- idpelanggan (Primary Key)
- namapelanggan (VARCHAR)
- jeniskelamin (BOOLEAN)
- noip (VARCHAR 12)
- alamat (VARCHAR 95)
- created_at, updated_at
```

### 2. **Meja** (Table)
```sql
- idmeja (Primary Key)
- nomormeja (VARCHAR 10)
- kapasitas (INTEGER)
- status (ENUM: kosong, terisi, maintenance)
- created_at, updated_at
```

### 3. **Menu**
```sql
- idmenu (Primary Key)
- namamenu (VARCHAR 100)
- harga (DECIMAL 12,2)
- aktif (BOOLEAN)
- created_at, updated_at
```

### 4. **Pesanan** (Order)
```sql
- idpesanan (Primary Key)
- idmeja (Foreign Key → Meja)
- iduser_waiter (Foreign Key → Users)
- idpelanggan (Foreign Key → Pelanggan)
- status (ENUM: pending, proses, selesai, lunas)
- total (DECIMAL 12,2)
- created_at, updated_at
```

### 5. **PesananDetail** (Order Detail)
```sql
- iddetail (Primary Key)
- idpesanan (Foreign Key → Pesanan)
- idmenu (Foreign Key → Menu)
- jumlah (INTEGER)
- harga (DECIMAL 12,2)
- subtotal (DECIMAL 12,2)
- status_item (ENUM: ORDERED, SERVED)
- created_at, updated_at
```

### 6. **Transaksi** (Transaction)
```sql
- idtransaksi (Primary Key)
- idpesanan (Foreign Key → Pesanan)
- idkasir (Foreign Key → Users)
- total (DECIMAL 12,2)
- bayar (DECIMAL 12,2)
- kembali (DECIMAL 12,2)
- metode_pembayaran (VARCHAR 20)
- created_at, updated_at
```

## ✅ **Models Created/Updated**

### 1. **Pelanggan Model**
- ✅ Created with proper relationships
- ✅ Fillable fields: namapelanggan, jeniskelamin, noip, alamat
- ✅ Relationship: hasMany(Pesanan::class)

### 2. **Meja Model**
- ✅ Updated with correct status values
- ✅ Relationship: hasMany(Pesanan::class)

### 3. **Menu Model**
- ✅ Already correct
- ✅ Relationship: hasMany(PesananDetail::class)

### 4. **Pesanan Model**
- ✅ Updated with idpelanggan field
- ✅ Relationships: belongsTo(Meja, User, Pelanggan), hasMany(PesananDetail), hasOne(Transaksi)

### 5. **PesananDetail Model**
- ✅ Already correct
- ✅ Relationships: belongsTo(Pesanan, Menu)

### 6. **Transaksi Model**
- ✅ Updated with bayar field
- ✅ Relationships: belongsTo(Pesanan, User)

## ✅ **Controllers Updated**

### 1. **PelangganController**
- ✅ CRUD operations for customer management
- ✅ Routes: GET, POST, PUT, DELETE /waiter/pelanggan

### 2. **WaiterController**
- ✅ Updated to include pelanggan relationships
- ✅ Updated storePesanan to include idpelanggan
- ✅ Added pelanggan to with() relationships

### 3. **KasirController**
- ✅ Updated to include pelanggan relationships
- ✅ Updated pesananSiapBayar to include pelanggan

### 4. **AdminController**
- ✅ Already correct for meja management

### 5. **OwnerController**
- ✅ Already correct for dashboard

## ✅ **Routes Updated**

### Authentication
- ✅ POST /login
- ✅ POST /logout
- ✅ GET /me

### Admin Routes
- ✅ GET /admin/
- ✅ POST /admin/meja
- ✅ PUT /admin/meja/{id}
- ✅ DELETE /admin/meja/{id}

### Waiter Routes
- ✅ GET /waiter/
- ✅ GET /waiter/menu
- ✅ POST /waiter/menu
- ✅ PUT /waiter/menu/{id}
- ✅ POST /waiter/pesanan
- ✅ PUT /waiter/pesanan/{id}
- ✅ GET /waiter/meja-kosong
- ✅ GET /waiter/pelanggan
- ✅ POST /waiter/pelanggan
- ✅ PUT /waiter/pelanggan/{id}
- ✅ DELETE /waiter/pelanggan/{id}

### Kasir Routes
- ✅ GET /kasir/
- ✅ POST /kasir/transaksi
- ✅ GET /kasir/pesanan-siap-bayar
- ✅ GET /kasir/hari-ini

### Owner Routes
- ✅ GET /owner/

## ✅ **Migration Files**

### Created/Updated:
1. ✅ `2025_10_03_003000_create_pelanggan_table.php` (NEW)
2. ✅ `2025_10_03_004755_create_mejas_table.php` (UPDATED - status values)
3. ✅ `2025_10_03_005642_create_menus_table.php` (ALREADY CORRECT)
4. ✅ `2025_10_03_011557_create_pesanans_table.php` (UPDATED - added idpelanggan)
5. ✅ `2025_10_03_013608_create_pesanan_details_table.php` (ALREADY CORRECT)
6. ✅ `2025_10_03_014324_create_transaksis_table.php` (UPDATED - added bayar field)

## ✅ **Database Relationships**

### Foreign Key Constraints:
- ✅ Pesanan.idmeja → Meja.idmeja
- ✅ Pesanan.iduser_waiter → Users.id
- ✅ Pesanan.idpelanggan → Pelanggan.idpelanggan
- ✅ PesananDetail.idpesanan → Pesanan.idpesanan
- ✅ PesananDetail.idmenu → Menu.idmenu
- ✅ Transaksi.idpesanan → Pesanan.idpesanan
- ✅ Transaksi.idkasir → Users.id

## ✅ **Status Values**

### Meja Status:
- ✅ kosong (available)
- ✅ terisi (occupied)
- ✅ maintenance

### Pesanan Status:
- ✅ pending (new order)
- ✅ proses (in progress)
- ✅ selesai (completed)
- ✅ lunas (paid)

### PesananDetail Status:
- ✅ ORDERED (ordered)
- ✅ SERVED (served)

## ✅ **All Systems Ready!**

Database schema now matches the requirements from the image:
- ✅ All 6 tables created with correct structure
- ✅ All relationships properly defined
- ✅ All controllers updated with correct functionality
- ✅ All routes properly configured
- ✅ All models with correct relationships
- ✅ Migration files in correct order
- ✅ Database successfully migrated
