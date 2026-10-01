
<?php
require_once __DIR__ . '/../Auth/Cek_Login.php';
require_once __DIR__ . '/../Config/Database.php';

$pesan = '';

$judul = '';
$penulis = '';
$penerbit = '';
$tahun = '';
$kategori = '';
$harga = '';
$stok = '';
$deskripsi = '';

function e($nilai) {
    return htmlspecialchars((string)$nilai, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul'] ?? '');
    $penulis = trim($_POST['penulis'] ?? '');
    $penerbit = trim($_POST['penerbit'] ?? '');
    $tahun = trim($_POST['tahun_terbit'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $harga = trim($_POST['harga'] ?? '');
    $stok = trim($_POST['stok'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');

    if (
        $judul === '' ||
        $penulis === '' ||
        $penerbit === '' ||
        $kategori === ''
    ) {
        $pesan = 'Judul, penulis, penerbit, dan kategori wajib diisi.';
    } elseif (
        !ctype_digit($tahun) ||
        (int)$tahun < 1000 ||
        (int)$tahun > 9999 ||
        !is_numeric($harga) ||
        (float)$harga < 0 ||
        !ctype_digit($stok)
    ) {
        $pesan = 'Periksa kembali tahun terbit, harga, dan stok.';
    } else {
        $sql = "INSERT INTO buku
                (judul, penulis, penerbit, tahun_terbit, kategori, harga, stok, deskripsi)
                VALUES
                (:judul, :penulis, :penerbit, :tahun, :kategori, :harga, :stok, :deskripsi)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'judul' => $judul,
            'penulis' => $penulis,
            'penerbit' => $penerbit,
            'tahun' => (int)$tahun,
            'kategori' => $kategori,
            'harga' => (float)$harga,
            'stok' => (int)$stok,
            'deskripsi' => $deskripsi
        ]);

        header("Location: Produk.php?pesan=berhasil_tambah");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - Pustaka Nusa</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f2f5f9;
            color: #1e293b;
            margin: 0;
            padding: 25px;
        }

        .panel {
            max-width: 650px;
            margin: 20px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .06);
        }

        h1 {
            margin-top: 0;
            color: #12483b;
        }

        label {
            display: block;
            margin-top: 14px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font: inherit;
        }

        textarea {
            resize: vertical;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #12483b;
        }

        button,
        .button {
            display: inline-block;
            margin-top: 18px;
            padding: 10px 14px;
            background: #12483b;
            color: white;
            border: 0;
            border-radius: 6px;
            text-decoration: none;
            font: inherit;
            cursor: pointer;
        }

        .button-secondary {
            background: #64748b;
        }

        .pesan {
            color: #b91c1c;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 6px;
            padding: 10px;
        }

        @media (max-width: 600px) {
            body {
                padding: 12px;
            }

            .panel {
                margin: 10px auto;
                padding: 18px;
            }
        }
    </style>
</head>

<body>
    <div class="panel">
        <h1>Tambah Buku</h1>
        <p>Isi informasi buku yang akan ditambahkan ke katalog Pustaka Nusa.</p>

        <?php if ($pesan !== ''): ?>
            <p class="pesan"><?= e($pesan) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="judul">Judul Buku</label>
            <input
                type="text"
                id="judul"
                name="judul"
                value="<?= e($judul) ?>"
                required
            >

            <label for="penulis">Penulis</label>
            <input
                type="text"
                id="penulis"
                name="penulis"
                value="<?= e($penulis) ?>"
                required
            >

            <label for="penerbit">Penerbit</label>
            <input
                type="text"
                id="penerbit"
                name="penerbit"
                value="<?= e($penerbit) ?>"
                required
            >

            <label for="tahun_terbit">Tahun Terbit</label>
            <input
                type="number"
                id="tahun_terbit"
                name="tahun_terbit"
                min="1000"
                max="9999"
                value="<?= e($tahun) ?>"
                required
            >

            <label for="kategori">Kategori</label>
            <input
                type="text"
                id="kategori"
                name="kategori"
                value="<?= e($kategori) ?>"
                required
            >

            <label for="harga">Harga (contoh: 95000)</label>
            <input
                type="number"
                id="harga"
                name="harga"
                min="0"
                step="1000"
                value="<?= e($harga) ?>"
                required
            >

            <label for="stok">Stok</label>
            <input
                type="number"
                id="stok"
                name="stok"
                min="0"
                value="<?= e($stok) ?>"
                required
            >

            <label for="deskripsi">Deskripsi</label>
            <textarea
                id="deskripsi"
                name="deskripsi"
                rows="5"
            ><?= e($deskripsi) ?></textarea>

            <button type="submit">Simpan Buku</button>
            <a class="button button-secondary" href="Produk.php">Batal</a>
        </form>
    </div>
</body>
</html>
