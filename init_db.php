<?php
$db = new SQLite3('db_toko.sqlite');

// BUAT TABEL DULU (INI YANG KURANG!)
$db->exec("CREATE TABLE IF NOT EXISTS produk (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nama TEXT,
    harga INTEGER,
    deskripsi TEXT,
    gambar TEXT
)");

// HAPUS DATA LAMA
$db->exec("DELETE FROM produk");

// ISI DATA BARU (SUDAH SESUAI)
$db->exec("
INSERT INTO produk (nama, harga, deskripsi, gambar) VALUES

('Baju 1', 90000, 'Atasan cantik', 'baju1.jpeg'),
('Baju 2', 105000, 'Atasan elegan', 'baju2.jpeg'),
('Baju 3', 75000, 'Atasan simple', 'baju3.jpeg'),
('Baju 4', 99000, 'Atasan modern', 'baju4.jpeg'),
('Baju 5', 78000, 'Atasan casual', 'baju5.jpeg'),
('Baju 6', 66000, 'Atasan santai', 'baju6.jpeg'),

('Gamis 1', 150000, 'Gamis elegan', 'gamis1.jpeg'),
('Gamis 2', 160000, 'Gamis modern', 'gamis2.jpeg'),
('Gamis 3', 155000, 'Gamis cantik', 'gamis3.jpeg'),
('Gamis 4', 163000, 'Gamis premium', 'gamis4.jpeg'),
('Gamis 5', 138000, 'Gamis casual', 'gamis5.jpeg'),
('Gamis 6', 130000, 'Gamis simple', 'gamis6.jpeg'),

('Tunik 1', 99000, 'Tunik nyaman', 'tunik1.jpeg'),
('Tunik 2', 115000, 'Tunik modern', 'tunik2.jpeg'),
('Tunik 3', 89000, 'Tunik simple', 'tunik3.jpeg'),
('Tunik 4', 120000, 'Tunik elegan', 'tunik4.jpeg'),
('Tunik 5', 135000, 'Tunik premium', 'tunik5.jpeg'),
('Tunik 6', 150000, 'Tunik exclusive', 'tunik6.jpeg')
");

echo "Database berhasil diisi!";
?>