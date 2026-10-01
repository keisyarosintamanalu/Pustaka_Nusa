
<?php
require_once __DIR__ . '/../Auth/Cek_Login.php';
require_once __DIR__ . '/../Config/Database.php';

// Penghapusan hanya boleh dilakukan melalui metode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: Produk.php");
    exit;
}

// Ambil ID buku dari formulir
$id = (int)($_POST['id'] ?? 0);

// Periksa ID sebelum menghapus data
if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM buku WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

// Kembali ke halaman Kelola Buku
header("Location: Produk.php");
exit;
