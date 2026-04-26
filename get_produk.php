<?php
header('Content-Type: application/json');

// pakai path absolut
$db = new SQLite3(__DIR__ . '/db_toko.sqlite');

// buat tabel jika belum ada
$db->exec("CREATE TABLE IF NOT EXISTS produk (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nama TEXT,
    harga INTEGER,
    deskripsi TEXT,
    gambar TEXT
)");

// cek apakah kosong
$cek = $db->querySingle("SELECT COUNT(*) FROM produk");

if ($cek == 0) {
    $db->exec("INSERT INTO produk (nama, harga, deskripsi, gambar) VALUES
    ('Gamis Elegan',120000,'Gamis bahan adem dan elegan','gamis1.jpeg'),
    ('Tunik Modern',95000,'Tunik kekinian nyaman dipakai','tunik1.jpeg'),
    ('Atasan Wanita',85000,'Atasan simple dan stylish','baju1.jpeg')");
}

// ambil data
$result = $db->query("SELECT * FROM produk");

$data = [];
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $data[] = $row;
}

echo json_encode($data);