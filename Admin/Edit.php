
<?php
require_once __DIR__ . '/../Auth/Cek_Login.php';
require_once __DIR__ . '/../Config/Database.php';

// Mengambil ID buku dari URL atau form
$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);

if ($id <= 0) {
    exit('ID buku tidak valid.');
}

// Mengambil data buku berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM buku WHERE id = :id");
$stmt->execute(['id' => $id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    exit('Data buku tidak ditemukan.');
}

$pesan = '';

// Memproses form ketika tombol Simpan Perubahan ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul'] ?? '');
    $penulis = trim($_POST['penulis'] ?? '');
    $penerbit = trim($_POST['penerbit'] ?? '');
    $tahun = filter_input(INPUT_POST, 'tahun_terbit', FILTER_VALIDATE_INT);
    $kategori = trim($_POST['kategori'] ?? '');
    $hargaInput = $_POST['harga'] ?? '';
    $stok = filter_input(INPUT_POST, 'stok', FILTER_VALIDATE_INT);
    $deskripsi = trim($_POST['deskripsi'] ?? '');

    // Nilai untuk ditampilkan kembali jika validasi gagal
    $item['judul'] = $judul;
    $item['penulis'] = $penulis;
    $item['penerbit'] = $penerbit;
    $item['tahun_terbit'] = $tahun !== false && $tahun !== null ? $tahun : '';
    $item['kategori'] = $kategori;
    $item['harga'] = $hargaInput;
    $item['stok'] = $stok !== false && $stok !== null ? $stok : '';
    $item['deskripsi'] = $deskripsi;

    if (
        $judul === '' ||
        $penulis === '' ||
        $penerbit === '' ||
        $kategori === ''
    ) {
        $pesan = 'Judul, penulis, penerbit, dan kategori wajib diisi.';
    } elseif (
        $tahun === false ||
        $tahun === null ||
        $tahun < 1000 ||
        $tahun > 9999
    ) {
        $pesan = 'Tahun terbit harus diisi antara 1000 dan 9999.';
    } elseif (
        $hargaInput === '' ||
        !is_numeric($hargaInput) ||
        (float) $hargaInput < 0
    ) {
        $pesan = 'Harga harus berupa angka dan tidak boleh negatif.';
    } elseif (
        $stok === false ||
        $stok === null ||
        $stok < 0
    ) {
        $pesan = 'Stok harus berupa angka bulat dan tidak boleh negatif.';
    } else {
        $sql = "UPDATE buku SET
                    judul = :judul,
                    penulis = :penulis,
                    penerbit = :penerbit,
                    tahun_terbit = :tahun,
                    kategori = :kategori,
                    harga = :harga,
                    stok = :stok,
                    deskripsi = :deskripsi
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'judul' => $judul,
            'penulis' => $penulis,
            'penerbit' => $penerbit,
            'tahun' => $tahun,
            'kategori' => $kategori,
            'harga' => (float) $hargaInput,
            'stok' => $stok,
            'deskripsi' => $deskripsi,
            'id' => $id
        ]);

        header("Location: Produk.php?pesan=berhasil_edit");
        exit;
    }
}

// Fungsi untuk mengamankan teks saat ditampilkan ke HTML
function e($value): string
{
    return htmlspecialchars(
        (string) ($value ?? ''),
        ENT_QUOTES,
        'UTF-8'
    );
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - Pustaka Nusa</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f5f9;
            padding: 25px;
            margin: 0;
            color: #1e293b;
        }

        .panel {
            max-width: 650px;
            margin: auto;
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
            box-sizing: border-box;
            font: inherit;
        }

        input:focus,
        textarea:focus {
            outline: 2px solid #a8c5b8;
            border-color: #12483b;
        }

        button,
        a.button {
            display: inline-block;
            margin-top: 18px;
            padding: 10px 14px;
            background: #12483b;
            color: white;
            border: 0;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            font: inherit;
        }

        a.button.secondary {
            background: #64748b;
        }

        .pesan {
            padding: 10px 12px;
            border-radius: 6px;
            background: #fef2f2;
            color: #b91c1c;
        }

        @media (max-width: 600px) {
            body {
                padding: 12px;
            }

            .panel {
                padding: 18px;
            }
        }
    </style>
</head>

<body>
    <div class="panel">
        <h1>Edit Buku</h1>

        <?php if ($pesan !== ''): ?>
            <p class="pesan"><?= e($pesan) ?></p>
        <?php endif; ?>

        <form method="POST" action="Edit.php?id=<?= (int) $id ?>">
            <input
                type="hidden"
                name="id"
                value="<?= (int) $item['id'] ?>"
            >

            <label for="judul">Judul Buku</label>
            <input
                type="text"
                id="judul"
                name="judul"
                value="<?= e($item['judul']) ?>"
                required
            >

            <label for="penulis">Penulis</label>
            <input
                type="text"
                id="penulis"
                name="penulis"
                value="<?= e($item['penulis']) ?>"
                required
            >

            <label for="penerbit">Penerbit</label>
            <input
                type="text"
                id="penerbit"
                name="penerbit"
                value="<?= e($item['penerbit']) ?>"
                required
            >

            <label for="tahun_terbit">Tahun Terbit</label>
            <input
                type="number"
                id="tahun_terbit"
                name="tahun_terbit"
                min="1000"
                max="9999"
                value="<?= e($item['tahun_terbit']) ?>"
                required
            >

            <label for="kategori">Kategori</label>
            <input
                type="text"
                id="kategori"
                name="kategori"
                value="<?= e($item['kategori']) ?>"
                required
            >

            <label for="harga">Harga</label>
            <input
                type="number"
                id="harga"
                name="harga"
                min="0"
                step="1000"
                value="<?= e($item['harga']) ?>"
                required
            >

            <label for="stok">Stok</label>
            <input
                type="number"
                id="stok"
                name="stok"
                min="0"
                step="1"
                value="<?= e($item['stok']) ?>"
                required
            >

            <label for="deskripsi">Deskripsi</label>
            <textarea
                id="deskripsi"
                name="deskripsi"
                rows="5"
            ><?= e($item['deskripsi'] ?? '') ?></textarea>

            <button type="submit">Simpan Perubahan</button>
            <a class="button secondary" href="Produk.php">Batal</a>
        </form>
    </div>
</body>
</html>
