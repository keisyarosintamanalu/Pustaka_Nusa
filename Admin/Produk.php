
<?php
require_once __DIR__ . '/../Auth/Cek_Login.php';
require_once __DIR__ . '/../Config/Database.php';

$stmt = $pdo->query(
    "SELECT id, judul, penulis, penerbit, tahun_terbit,
            kategori, harga, stok
     FROM buku
     ORDER BY id DESC"
);

$buku = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Buku - Pustaka Nusa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f5f9;
            padding: 25px;
            margin: 0;
        }

        .panel {
            background: white;
            padding: 20px;
            border-radius: 10px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #12483b;
            color: white;
        }

        a, button {
            cursor: pointer;
        }

        .button {
            display: inline-block;
            padding: 9px 12px;
            background: #12483b;
            color: white;
            text-decoration: none;
            border: 0;
            border-radius: 5px;
            font: inherit;
            font-size: 14px;
        }

        .hapus {
            background: #b91c1c;
        }

        .aksi {
            white-space: nowrap;
        }

        @media (max-width: 600px) {
            body {
                padding: 12px;
            }

            .panel {
                padding: 15px;
            }

            th, td {
                padding: 8px;
                font-size: 13px;
            }
        }
    </style>
</head>
<body>
    <div class="panel">
        <h1>Kelola Buku</h1>

        <a class="button" href="Index.php">Dashboard</a>
        <a class="button" href="Tambah.php">+ Tambah Buku</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($buku as $item): ?>
                    <tr>
                        <td><?= (int) $item['id'] ?></td>

                        <td>
                            <?= htmlspecialchars(
                                $item['judul'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $item['penulis'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $item['kategori'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            Rp<?= number_format(
                                (float) $item['harga'],
                                0,
                                ',',
                                '.'
                            ) ?>
                        </td>

                        <td><?= (int) $item['stok'] ?></td>

                        <td class="aksi">
                            <a
                                class="button"
                                href="Edit.php?id=<?= (int) $item['id'] ?>"
                            >Edit</a>

                            <form
                                action="Hapus.php"
                                method="POST"
                                style="display:inline"
                                onsubmit="return confirm('Yakin ingin menghapus buku ini?')"
                            >
                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= (int) $item['id'] ?>"
                                >

                                <button
                                    class="button hapus"
                                    type="submit"
                                >Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (count($buku) === 0): ?>
                    <tr>
                        <td colspan="7">Belum ada data buku.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
