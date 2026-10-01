
<?php
require_once __DIR__ . '/Config/Database.php';

function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    http_response_code(400);
    exit('ID buku tidak valid.');
}

$stmt = $pdo->prepare("SELECT * FROM buku WHERE id = :id");
$stmt->execute(['id' => $id]);
$buku = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$buku) {
    http_response_code(404);
    exit('Buku tidak ditemukan.');
}

$cover = basename((string) ($buku['cover'] ?? ''));
$coverPath = __DIR__ . '/Assets/img/Cover/' . $cover;

if ($cover === '' || !is_file($coverPath)) {
    $coverUrl = 'Assets/img/Cover/cover-default.svg';
} else {
    $coverUrl = 'Assets/img/Cover/' . rawurlencode($cover);
}

if ($cover === '' || !is_file($coverPath)) {
    $coverUrl = 'Assets/img/Cover/cover-default.svg';
} else {
    $coverUrl = 'Assets/img/Cover/' . rawurlencode($cover);
}

// NOMOR DAN PESAN WHATSAPP
$waNumber = '+6285643957466'; 
$waMessage = "Halo, saya ingin memesan buku *"
    . $buku['filosofi teras']
    . "* di Pustaka Nusa. Apakah stok masih tersedia? "
    . "Mohon info cara pemesanannya. Terima kasih.";

$waUrl = 'https://wa.me/' . $waNumber
    . '?text=' . rawurlencode($waMessage);
?>

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($buku['judul']) ?> | Pustaka Nusa</title>
    <link rel="stylesheet" href="Assets/style.css">

<style>
    /* DETAIL PAGE - PUSTAKA NUSA */

    body {
        background: #f6f7f4;
        color: #20352d;
        font-family: "Segoe UI", Arial, sans-serif;
    }

    /* NAVBAR */
    .navbar {
        position: sticky;
        top: 0;
        z-index: 100;
        background: rgba(255, 255, 255, .97);
        border-bottom: 1px solid #e7ece8;
        box-shadow: 0 3px 15px rgba(20, 50, 35, .04);
    }

    .nav-inner {
        width: min(1160px, calc(100% - 48px));
        min-height: 72px;
        margin: auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
    }

    .brand {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: #12483b;
        font-size: 20px;
        font-weight: 750;
        text-decoration: none;
        white-space: nowrap;
    }

    .brand-mark {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: #e8f1ec;
        color: #12483b;
        font-size: 21px;
    }

    .nav-links {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .nav-links a {
        padding: 10px 14px;
        border-radius: 8px;
        color: #52645b;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: .2s ease;
    }

    .nav-links a:hover,
    .nav-links a.active {
        background: #eaf2ed;
        color: #12483b;
    }

    .nav-links a.nav-admin {
        background: #12483b;
        color: #fff;
        margin-left: 5px;
    }

    .nav-links a.nav-admin:hover {
        background: #0b332a;
    }

    /* MAIN LAYOUT */
    .container {
        width: min(1160px, calc(100% - 48px));
        margin-left: auto;
        margin-right: auto;
    }

    .detail-shell {
        padding-top: 30px;
        padding-bottom: 65px;
    }

    .breadcrumb {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        margin-bottom: 22px;
        color: #849188;
        font-size: 12px;
        line-height: 1.8;
        overflow-wrap: anywhere;
    }

    .breadcrumb a {
        color: #547365;
        text-decoration: none;
        transition: color .2s;
    }

    .breadcrumb a:hover {
        color: #12483b;
        text-decoration: underline;
    }

    /* BOOK DETAIL CARD */
    .detail-card {
        display: grid;
        grid-template-columns: minmax(280px, 390px) minmax(0, 1fr);
        align-items: start;
        gap: 45px;
        padding: 38px;
        background: #fff;
        border: 1px solid #e8ede9;
        border-radius: 20px;
        box-shadow: 0 12px 38px rgba(25, 55, 38, .07);
    }

.detail-cover {
    width: 100%;
    min-height: 430px;
    padding: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f1f4f0;
    border: 1px solid #e9eee9;
    border-radius: 15px;
    overflow: hidden;
}

.detail-cover img {
    display: block;
    width: 100%;
    max-width: 370px;
    max-height: 540px;
    height: auto;
    object-fit: contain;
    border-radius: 5px;
    filter: drop-shadow(0 12px 13px rgba(0, 0, 0, .15));
}

    .detail-info {
        min-width: 0;
        padding: 4px 0;
    }

    .book-category {
        display: inline-flex;
        align-items: center;
        padding: 7px 12px;
        margin-bottom: 15px;
        border-radius: 30px;
        background: #eaf3ed;
        color: #286148;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .5px;
        text-transform: uppercase;
    }

    .detail-info h1 {
        margin: 0 0 12px;
        color: #173a2e;
        font-size: clamp(27px, 3.2vw, 39px);
        font-weight: 750;
        line-height: 1.22;
        letter-spacing: -.8px;
        overflow-wrap: anywhere;
    }

    .detail-author {
        margin: 0;
        color: #718078;
        font-size: 14px;
        line-height: 1.7;
    }

    .detail-author strong {
        color: #304b3e;
        font-weight: 650;
    }

    .detail-price {
        margin: 23px 0;
        color: #12483b;
        font-size: 29px;
        font-weight: 750;
        letter-spacing: -.5px;
    }

    .book-meta {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin: 0 0 28px;
    }

    .meta-box {
        min-width: 0;
        padding: 15px 16px;
        background: #f8faf8;
        border: 1px solid #e9eee9;
        border-radius: 11px;
    }

    .meta-box span {
        display: block;
        margin-bottom: 7px;
        color: #819087;
        font-size: 11px;
        font-weight: 600;
    }

    .meta-box strong {
        display: block;
        color: #2b4035;
        font-size: 13px;
        font-weight: 700;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .detail-info h3 {
        margin: 0 0 10px;
        color: #203d30;
        font-size: 17px;
        font-weight: 700;
    }

    .description {
        margin: 0;
        color: #637269;
        font-size: 13px;
        line-height: 1.9;
        overflow-wrap: anywhere;
    }

    .form-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 27px;
    }

    .form-actions .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 43px;
        padding: 11px 17px;
        border: 1px solid #12483b;
        border-radius: 9px;
        background: #12483b;
        color: #fff;
        font-size: 12px;
        font-weight: 650;
        text-decoration: none;
        transition: .2s ease;
    }

    .form-actions .btn:hover {
        background: #0b332a;
        border-color: #0b332a;
        transform: translateY(-1px);
    }

    /* TOMBOL WHATSAPP */
    .form-actions .btn-whatsapp {
    background: #16834b;
    border-color: #16834b;
    }

    .form-actions .btn-whatsapp:hover {
    background: #116b3c;
    border-color: #116b3c;
    }

    /* FOOTER */
    .site-footer {
        padding: 20px 0;
        background: #0b332a;
        color: #d8e6df;
        text-align: center;
    }

    .site-footer p {
        margin: 0;
        font-size: 11px;
        line-height: 1.7;
    }

    /* TABLET */
    @media (max-width: 850px) {
        .detail-card {
            grid-template-columns: minmax(230px, 320px) minmax(0, 1fr);
            gap: 27px;
            padding: 27px;
        }

        .detail-cover {
            min-height: 320px;
            padding: 15px;
        }

        .detail-cover img {
            max-height: 400px;
        }

        .detail-price {
            font-size: 25px;
        }
    }

    /* MOBILE */
    @media (max-width: 650px) {
        .nav-inner {
            width: calc(100% - 30px);
            min-height: 65px;
            flex-wrap: wrap;
            gap: 8px;
            padding: 11px 0;
        }

        .brand {
            font-size: 17px;
        }

        .brand-mark {
            width: 32px;
            height: 32px;
            font-size: 18px;
        }

        .nav-links {
            width: 100%;
            gap: 5px;
            justify-content: flex-start;
            overflow-x: auto;
        }

        .nav-links a {
            padding: 8px 10px;
            font-size: 11px;
            white-space: nowrap;
        }

        .container {
            width: calc(100% - 30px);
        }

        .detail-shell {
            padding-top: 20px;
            padding-bottom: 38px;
        }

        .breadcrumb {
            margin-bottom: 15px;
            font-size: 11px;
        }

        .detail-card {
            grid-template-columns: minmax(0, 1fr);
            gap: 24px;
            padding: 17px;
            border-radius: 15px;
        }

        .detail-cover {
            min-height: 0;
            height: 370px;
            padding: 12px;
        }

        .detail-cover img {
            width: auto;
            max-width: 100%;
            max-height: 345px;
        }

        .detail-info h1 {
            font-size: 27px;
        }

        .detail-price {
            margin: 17px 0;
            font-size: 25px;
        }

        .book-meta {
            gap: 9px;
            margin-bottom: 23px;
        }

        .meta-box {
            padding: 12px;
        }

        .meta-box span {
            font-size: 10px;
        }

        .meta-box strong {
            font-size: 12px;
        }

        .description {
            font-size: 12px;
        }

        .form-actions .btn {
            width: 100%;
        }
    }

    @media (max-width: 360px) {
        .book-meta {
            grid-template-columns: 1fr;
        }
    }
</style>

</head>
<body>

<nav class="navbar">
    <div class="nav-inner">
        <a class="brand" href="Index.php">
            <span class="brand-mark">✦</span>
            <span>Pustaka Nusa</span>
        </a>
        <div class="nav-links">
            <a href="Index.php">Beranda</a>
            <a class="active" href="Index.php#koleksi">Koleksi</a>
            <a class="nav-admin" href="Auth/Login.php">Admin</a>
        </div>
    </div>
</nav>

<main class="container detail-shell">
    <div class="breadcrumb">
        <a href="Index.php">Beranda</a> &nbsp; / &nbsp;
        <a href="Index.php#koleksi">Koleksi Buku</a> &nbsp; / &nbsp;
        <?= e($buku['judul']) ?>
    </div>

    <section class="detail-card">
        <div class="detail-cover">
            <img
                src="<?= e($coverUrl) ?>"
                alt="Sampul buku <?= e($buku['judul']) ?>"
                onerror="this.onerror=null;this.src='Assets/img/Cover/cover-default.svg';"
            >
        </div>

        <div class="detail-info">
            <span class="book-category"><?= e($buku['kategori']) ?></span>
            <h1><?= e($buku['judul']) ?></h1>
            <p class="detail-author">Ditulis oleh <strong><?= e($buku['penulis']) ?></strong></p>

            <div class="detail-price">
                Rp<?= number_format((float) $buku['harga'], 0, ',', '.') ?>
            </div>

            <div class="book-meta">
                <div class="meta-box">
                    <span>Penerbit</span>
                    <strong><?= e($buku['penerbit']) ?></strong>
                </div>
                <div class="meta-box">
                    <span>Tahun Terbit</span>
                    <strong><?= e($buku['tahun_terbit']) ?></strong>
                </div>
                <div class="meta-box">
                    <span>Kategori</span>
                    <strong><?= e($buku['kategori']) ?></strong>
                </div>
                <div class="meta-box">
                    <span>Stok Tersedia</span>
                    <strong><?= (int) $buku['stok'] ?> buku</strong>
                </div>
            </div>

            <h3>Deskripsi Buku</h3>
            <p class="description">
                <?= nl2br(e($buku['deskripsi'] ?: 'Deskripsi buku belum tersedia.')) ?>
            </p>

            
<div class="form-actions">
    <a class="btn" href="Index.php#koleksi">
        ← Kembali ke koleksi
    </a>

    <a
        class="btn btn-whatsapp"
        href="<?= e($waUrl) ?>"
        target="_blank"
        rel="noopener noreferrer"
    >
        ☎ Pesan via WhatsApp
    </a>
</div>

        </div>
    </section>
</main>

<footer class="site-footer">
    <div class="container">
        <p>&copy; <?= date('Y') ?> Pustaka Nusa. Semua hak dilindungi.</p>
    </div>
</footer>

</body>
</html>
