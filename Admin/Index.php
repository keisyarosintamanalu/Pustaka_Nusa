
<?php
require_once __DIR__ . '/../Auth/Cek_Login.php';

$namaAdmin = htmlspecialchars(
    $_SESSION['admin_nama'] ?? 'Admin',
    ENT_QUOTES,
    'UTF-8'
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Pustaka Nusa</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --green: #12483b;
            --green-dark: #0b332a;
            --green-light: #e8f1ec;
            --cream: #f7f8f5;
            --white: #ffffff;
            --text: #1c2b25;
            --muted: #718078;
            --border: #e6ebe7;
            --red: #b42318;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: var(--cream);
            color: var(--text);
            min-height: 100vh;
        }

        a {
            text-decoration: none;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            background: var(--green-dark);
            color: white;
            padding: 28px 18px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px 35px;
            border-bottom: 1px solid rgba(255,255,255,.13);
        }

        .brand-icon {
            width: 43px;
            height: 43px;
            border-radius: 13px;
            background: rgba(255,255,255,.13);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        .brand-name {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: .2px;
        }

        .brand-subtitle {
            font-size: 11px;
            color: #b8d0c5;
            margin-top: 4px;
            letter-spacing: 1.2px;
        }

        .menu-label {
            color: #9db9ad;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            padding: 28px 12px 12px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #d3e1d9;
            padding: 13px 14px;
            border-radius: 10px;
            font-size: 13px;
            transition: .2s;
        }

        .menu a:hover,
        .menu a.active {
            background: rgba(255,255,255,.13);
            color: white;
        }

        .menu-icon {
            width: 22px;
            text-align: center;
            font-size: 17px;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 25px;
        }

        .admin-mini {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 14px 10px;
            border-top: 1px solid rgba(255,255,255,.13);
        }

        .avatar {
            width: 37px;
            height: 37px;
            border-radius: 50%;
            background: #d9e8df;
            color: var(--green-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            flex-shrink: 0;
        }

        .admin-name {
            font-size: 12px;
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .admin-role {
            color: #a9c3b7;
            font-size: 11px;
            margin-top: 4px;
        }

        /* MAIN CONTENT */
        .main {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            height: 76px;
            background: var(--white);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5%;
        }

        .breadcrumb {
            font-size: 12px;
            color: var(--muted);
        }

        .breadcrumb strong {
            color: var(--green);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--muted);
            font-size: 12px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22a06b;
        }

        .content {
            max-width: 1200px;
            padding: 38px 5%;
            margin: auto;
        }

        .welcome {
            background: linear-gradient(120deg, #12483b, #1c6652);
            color: white;
            border-radius: 18px;
            padding: 35px 38px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 25px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 12px 30px rgba(18,72,59,.12);
        }

        .welcome::after {
            content: "✦";
            position: absolute;
            right: 10%;
            top: -58px;
            font-size: 220px;
            color: rgba(255,255,255,.055);
            line-height: 1;
            pointer-events: none;
        }

        .welcome-text {
            position: relative;
            z-index: 1;
        }

        .eyebrow {
            color: #c4dfd1;
            font-size: 11px;
            letter-spacing: 1.7px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 13px;
        }

        .welcome h1 {
            font-size: clamp(23px, 3vw, 32px);
            line-height: 1.25;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .welcome p {
            color: #d5e6de;
            font-size: 13px;
            line-height: 1.7;
            max-width: 520px;
        }

        .welcome-mark {
            position: relative;
            z-index: 1;
            width: 105px;
            height: 105px;
            border-radius: 24px;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 47px;
            flex-shrink: 0;
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 15px;
            margin: 34px 0 17px;
        }

        .section-heading h2 {
            font-size: 19px;
            color: var(--text);
            margin-bottom: 6px;
        }

        .section-heading p {
            font-size: 12px;
            color: var(--muted);
        }

        .section-tag {
            font-size: 11px;
            color: var(--green);
            background: var(--green-light);
            padding: 7px 11px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 17px;
        }

        .action-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 15px;
            padding: 23px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            transition: transform .2s, box-shadow .2s, border-color .2s;
            min-height: 155px;
        }

        .action-card:hover {
            transform: translateY(-3px);
            border-color: #bfd4c7;
            box-shadow: 0 12px 25px rgba(26,57,42,.07);
        }

        .card-icon {
            width: 49px;
            height: 49px;
            border-radius: 13px;
            background: var(--green-light);
            color: var(--green);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
            flex-shrink: 0;
        }

        .card-info {
            flex: 1;
            min-width: 0;
        }

        .card-info h3 {
            font-size: 15px;
            margin: 3px 0 8px;
            color: var(--text);
        }

        .card-info p {
            font-size: 12px;
            color: var(--muted);
            line-height: 1.7;
        }

        .card-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-top: 15px;
            color: var(--green);
            font-size: 12px;
            font-weight: 700;
        }

        .card-link span {
            transition: transform .2s;
        }

        .action-card:hover .card-link span {
            transform: translateX(4px);
        }

        .bottom-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 13px;
            margin-top: 20px;
            padding: 17px 20px;
        }

        .bottom-row p {
            font-size: 12px;
            color: var(--muted);
            line-height: 1.6;
        }

        .bottom-row strong {
            color: var(--text);
        }

        .logout {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fff1f0;
            color: var(--red);
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            transition: .2s;
        }

        .logout:hover {
            background: #ffe1df;
        }

        .footer {
            padding: 18px 5% 25px;
            color: #8b9890;
            font-size: 11px;
            text-align: center;
        }

        @media (max-width: 800px) {
            .sidebar {
                width: 205px;
                padding: 22px 12px;
            }

            .content {
                padding: 28px 4%;
            }

            .welcome {
                padding: 27px;
            }

            .welcome-mark {
                width: 78px;
                height: 78px;
                font-size: 35px;
            }
        }

        @media (max-width: 600px) {
            .layout {
                display: block;
            }

            .sidebar {
                width: 100%;
                padding: 13px 16px;
            }

            .brand {
                padding: 0 2px 12px;
                border-bottom: 0;
            }

            .brand-icon {
                width: 37px;
                height: 37px;
                font-size: 20px;
            }

            .brand-name {
                font-size: 16px;
            }

            .brand-subtitle {
                font-size: 9px;
            }

            .menu-label,
            .sidebar-bottom {
                display: none;
            }

            .menu {
                flex-direction: row;
                gap: 7px;
                overflow-x: auto;
                padding-top: 10px;
            }

            .menu a {
                padding: 9px 11px;
                font-size: 11px;
                white-space: nowrap;
            }

            .menu-icon {
                font-size: 14px;
                width: auto;
            }

            .topbar {
                height: 52px;
                padding: 0 18px;
            }

            .topbar-right {
                font-size: 10px;
            }

            .content {
                padding: 23px 16px;
            }

            .welcome {
                padding: 23px 20px;
                border-radius: 14px;
            }

            .welcome h1 {
                font-size: 23px;
            }

            .welcome p {
                font-size: 12px;
            }

            .welcome-mark {
                display: none;
            }

            .section-heading {
                margin-top: 27px;
            }

            .section-heading h2 {
                font-size: 17px;
            }

            .cards {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .action-card {
                min-height: auto;
                padding: 18px;
            }

            .bottom-row {
                align-items: flex-start;
                flex-direction: column;
            }

            .footer {
                padding-bottom: 20px;
            }
        }
    </style>
</head>

<body>
<div class="layout">

    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon">✦</div>
            <div>
                <div class="brand-name">Pustaka Nusa</div>
                <div class="brand-subtitle">BOOKSTORE MANAGEMENT</div>
            </div>
        </div>

        <div class="menu-label">MENU UTAMA</div>

        <nav class="menu">
            <a href="Index.php" class="active">
                <span class="menu-icon">⌂</span>
                Dashboard
            </a>
            <a href="Produk.php">
                <span class="menu-icon">▤</span>
                Kelola Buku
            </a>
            <a href="Tambah.php">
                <span class="menu-icon">＋</span>
                Tambah Buku
            </a>
            <a href="../Index.php">
                <span class="menu-icon">↗</span>
                Lihat Website
            </a>
        </nav>

        <div class="sidebar-bottom">
            <div class="admin-mini">
                <div class="avatar">
                    <?= strtoupper(substr($namaAdmin, 0, 1)) ?>
                </div>
                <div>
                    <div class="admin-name"><?= $namaAdmin ?></div>
                    <div class="admin-role">Administrator</div>
                </div>
            </div>
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
            <div class="breadcrumb">
                Pustaka Nusa &nbsp; / &nbsp; <strong>Dashboard</strong>
            </div>
            <div class="topbar-right">
                <span class="status-dot"></span>
                Admin aktif
            </div>
        </div>

        <div class="content">
            <section class="welcome">
                <div class="welcome-text">
                    <div class="eyebrow">ADMINISTRATION PANEL</div>
                    <h1>Selamat datang, <?= $namaAdmin ?>!</h1>
                    <p>
                        Kelola koleksi buku Pustaka Nusa dengan mudah.
                        Pilih menu di bawah untuk mulai mengelola katalog.
                    </p>
                </div>
                <div class="welcome-mark">📚</div>
            </section>

            <div class="section-heading">
                <div>
                    <h2>Akses cepat</h2>
                    <p>Pilih aktivitas yang ingin kamu lakukan.</p>
                </div>
                <span class="section-tag">PANEL ADMIN</span>
            </div>

            <section class="cards">
                <a href="Produk.php" class="action-card">
                    <div class="card-icon">▤</div>
                    <div class="card-info">
                        <h3>Kelola Buku</h3>
                        <p>Lihat seluruh koleksi buku, perbarui informasi, dan kelola ketersediaan stok.</p>
                        <span class="card-link">Buka katalog <span>→</span></span>
                    </div>
                </a>

                <a href="Tambah.php" class="action-card">
                    <div class="card-icon">＋</div>
                    <div class="card-info">
                        <h3>Tambah Buku</h3>
                        <p>Masukkan buku baru beserta informasi judul, penulis, harga, dan deskripsi.</p>
                        <span class="card-link">Tambah koleksi <span>→</span></span>
                    </div>
                </a>

                <a href="../Index.php" class="action-card">
                    <div class="card-icon">⌂</div>
                    <div class="card-info">
                        <h3>Lihat Website</h3>
                        <p>Tinjau tampilan katalog Pustaka Nusa seperti yang dilihat oleh pengunjung.</p>
                        <span class="card-link">Kunjungi website <span>→</span></span>
                    </div>
                </a>

                <a href="Produk.php" class="action-card">
                    <div class="card-icon">✎</div>
                    <div class="card-info">
                        <h3>Perbarui Koleksi</h3>
                        <p>Masuk ke daftar buku untuk mengedit detail dan menyesuaikan data koleksi.</p>
                        <span class="card-link">Kelola data <span>→</span></span>
                    </div>
                </a>
            </section>

            <div class="bottom-row">
                <p>
                    <strong>Sesi Administrator</strong><br>
                    Kamu sedang masuk sebagai <?= $namaAdmin ?>.
                    Pastikan keluar setelah selesai mengelola katalog.
                </p>
                <a href="../Auth/Logout.php" class="logout">
                    ↪ &nbsp; Logout
                </a>
            </div>
        </div>

        <footer class="footer">
            © 2026 Pustaka Nusa. Semua hak dilindungi.
        </footer>
    </main>

</div>
</body>
</html>
