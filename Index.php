
<?php
// ============================================
// KONEKSI DATABASE
// ============================================
$host = '127.0.0.1';
$dbname = 'pustaka_nusa';
$username = 'root';
$password = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Koneksi database gagal. Periksa konfigurasi database di Index.php.");
}

// ============================================
// PENCARIAN BUKU
// ============================================
$keyword = trim($_GET['q'] ?? '');

try {
    if ($keyword !== '') {
        $stmt = $pdo->prepare(
            "SELECT * FROM buku
             WHERE judul LIKE :keyword
                OR penulis LIKE :keyword
                OR kategori LIKE :keyword
             ORDER BY id DESC"
        );
        $stmt->execute(['keyword' => "%$keyword%"]);
    } else {
        $stmt = $pdo->query("SELECT * FROM buku ORDER BY id DESC");
    }

    $buku = $stmt->fetchAll();
} catch (PDOException $e) {
    $buku = [];
}

// ============================================
// FUNGSI BANTU
// ============================================
function e($value): string
{
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function formatRupiah($angka): string
{
    return 'Rp' . number_format((float)$angka, 0, ',', '.');
}

function coverBuku($cover): string
{
    $cover = trim((string)($cover ?? ''));

    if ($cover === '') {
        return 'Assets/img/Cover_default.svg';
    }

    // Mendukung nama file saja atau path yang sudah tersimpan di database.
    $namaFile = basename(str_replace('\\', '/', $cover));
    $path = 'Assets/img/Cover/' . rawurlencode($namaFile);

    return $path;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pustaka Nusa | Temukan Cerita, Temukan Makna</title>
    <link rel="stylesheet" href="Assets/Style.css">
</head>
<body>

<!-- ================= HEADER ================= -->
<header class="site-header">
    <div class="nav-container">
        <a href="Index.php" class="brand">
            <span class="brand-icon" aria-hidden="true">
                <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 11.5c6-2 11.5-1.3 17 2.2v25c-5.5-3.5-11-4.2-17-2.2z"/>
                    <path d="M41 11.5c-6-2-11.5-1.3-17 2.2v25c5.5-3.5 11-4.2-17-2.2z"/>
                    <path d="M12 18c3.5-.6 6.5.1 9 1.5M12 24c3.5-.6 6.5.1 9 1.5M36 18c-3.5-.6-6.5.1-9 1.5M36 24c-3.5-.6-6.5.1-9 1.5"/>
                </svg>
            </span>
            <span class="brand-name">Pustaka <strong>Nusa</strong></span>
        </a>

        <nav class="main-nav" aria-label="Navigasi utama">
            <a href="Index.php" class="nav-link active">Beranda</a>
            <a href="#koleksi" class="nav-link">Koleksi Buku</a>
            <a href="#inspirasi" class="nav-link">Inspirasi</a>
            <a href="#ruang-membaca" class="nav-link">Ruang Membaca</a>
        </nav>

        <a href="Admin/Index.php" class="admin-link">Admin <span aria-hidden="true">↗</span></a>
    </div>
</header>

<main>
    <!-- ================= HERO ================= -->
    <section class="hero">
        <div class="hero-inner">
            <div class="hero-copy">
                <span class="eyebrow"><span class="eyebrow-dot"></span> SELAMAT DATANG DI PUSTAKA NUSA</span>

                <h1>Setiap buku punya cerita.<br><span>Temukan ceritamu.</span></h1>

                <p class="hero-description">
                    Jelajahi pilihan bacaan yang membuka wawasan,
                    menumbuhkan imajinasi, dan menemani setiap perjalananmu.
                </p>

                <div class="hero-actions">
                    <a href="#koleksi" class="button button-primary">
                        Jelajahi Koleksi <span aria-hidden="true">→</span>
                    </a>
                    <a href="#ruang-membaca" class="button button-secondary">
                        Kenali Kami
                    </a>
                </div>

                <div class="hero-note">
                    <span class="note-icon" aria-hidden="true">✦</span>
                    <span>Temukan bacaan yang bermakna, satu halaman demi satu halaman.</span>
                </div>
            </div>

            <div class="hero-art" aria-label="Ilustrasi buku">
                <div class="art-circle art-circle-one"></div>
                <div class="art-circle art-circle-two"></div>
                <div class="floating-label label-top">A world of stories</div>

                <div class="book-stack">
                    <div class="book book-back">
                        <span class="book-line"></span>
                        <span class="book-title">IDEAS<br>TO GROW</span>
                        <span class="book-small">READ • LEARN • EXPLORE</span>
                    </div>
                    <div class="book book-middle">
                        <span class="book-small">THE ART OF</span>
                        <span class="book-title">LIVING<br>WELL</span>
                        <span class="book-line"></span>
                    </div>
                    <div class="book book-front">
                        <span class="book-emblem">✦</span>
                        <span class="book-small">A GOOD BOOK</span>
                        <span class="book-title">OPENS<br>NEW WORLDS</span>
                        <span class="book-line"></span>
                        <span class="book-small">PUSTAKA NUSA</span>
                    </div>
                </div>

                <div class="floating-label label-bottom">
                    <span class="label-sparkle">✧</span>
                    Inspiration starts here
                </div>
            </div>
        </div>
        <div class="hero-bottom-line"></div>
    </section>

    <!-- ================= FITUR KLIK ================= -->
    <section class="features-wrap" aria-label="Fitur Pustaka Nusa">
        <div class="features">
            <a href="#koleksi" class="feature-card">
                <span class="feature-icon" aria-hidden="true">
                    <svg viewBox="0 0 48 48">
                        <path d="M10 8h24a4 4 0 0 1 4 4v28H14a4 4 0 0 1-4-4z"/>
                        <path d="M10 13h28M10 20h28M10 27h28M10 34h28"/>
                        <path d="M14 8v32"/>
                    </svg>
                </span>
                <span class="feature-copy">
                    <strong>Koleksi Pilihan</strong>
                    <span>Bacaan untuk berbagi minat</span>
                </span>
                <span class="feature-arrow" aria-hidden="true">↗</span>
            </a>

            <a href="#inspirasi" class="feature-card">
                <span class="feature-icon" aria-hidden="true">
                    <svg viewBox="0 0 48 48">
                        <path d="M24 5l4.2 14.8L43 24l-14.8 4.2L24 43l-4.2-14.8L5 24l14.8-4.2z"/>
                        <circle cx="36.5" cy="10.5" r="2"/>
                        <circle cx="10" cy="37" r="1.8"/>
                    </svg>
                </span>
                <span class="feature-copy">
                    <strong>Temukan Inspirasi</strong>
                    <span>Ide baru dari setiap buku</span>
                </span>
                <span class="feature-arrow" aria-hidden="true">↗</span>
            </a>

            <a href="#ruang-membaca" class="feature-card">
                <span class="feature-icon" aria-hidden="true">
                    <svg viewBox="0 0 48 48">
                        <path d="M24 40S7 30 7 18.5C7 9 19 6 24 15c5-9 17-6 17 3.5C41 30 24 40 24 40z"/>
                        <path d="M15 22c2 2 4 3 7 3"/>
                    </svg>
                </span>
                <span class="feature-copy">
                    <strong>Ruang Membaca</strong>
                    <span>Teman dalam perjalanan ilmu</span>
                </span>
                <span class="feature-arrow" aria-hidden="true">↗</span>
            </a>
        </div>
    </section>

    <!-- ================= KOLEKSI BUKU ================= -->
    <section class="section collection-section" id="koleksi">
        <div class="section-heading">
            <div>
                <span class="section-kicker">JELAJAHI BACAAN</span>
                <h2>Koleksi <span>Pilihan</span></h2>
                <p>Temukan buku yang sesuai dengan rasa ingin tahu dan minatmu.</p>
            </div>
            <span class="section-count"><?= count($buku) ?> buku tersedia</span>
        </div>

        <form action="Index.php#koleksi" method="GET" class="search-form">
            <span class="search-icon" aria-hidden="true">⌕</span>
            <input
                type="search"
                name="q"
                placeholder="Cari judul buku, penulis, atau kategori..."
                value="<?= e($keyword) ?>"
                aria-label="Cari buku"
            >
            <button type="submit">Cari Buku</button>
        </form>

        <?php if ($keyword !== ''): ?>
            <p class="search-result">
                Hasil pencarian untuk: <strong><?= e($keyword) ?></strong>
                <a href="Index.php#koleksi">Hapus pencarian</a>
            </p>
        <?php endif; ?>

        <?php if (count($buku) > 0): ?>
            <div class="book-grid">
                <?php foreach ($buku as $item): ?>
                    <article class="book-card">
                        <a class="book-cover-link" href="Detail.php?id=<?= (int)$item['id'] ?>">
                            <div class="book-cover">
                                <img
                                    src="<?= e(coverBuku($item['cover'] ?? '')) ?>"
                                    alt="Sampul buku <?= e($item['judul'] ?? 'Buku') ?>"
                                    loading="lazy"
                                    onerror="this.onerror=null;this.src='Assets/img/Cover_default.svg';"
                                >
                                <span class="cover-overlay">Lihat detail <span aria-hidden="true">↗</span></span>
                            </div>
                        </a>

                        <div class="book-info">
                            <span class="book-category"><?= e($item['kategori'] ?? 'Bacaan') ?></span>
                            <h3>
                                <a href="Detail.php?id=<?= (int)$item['id'] ?>">
                                    <?= e($item['judul'] ?? 'Tanpa Judul') ?>
                                </a>
                            </h3>
                            <p class="book-author"><?= e($item['penulis'] ?? 'Penulis tidak diketahui') ?></p>

                            <div class="book-card-bottom">
                                <strong class="book-price"><?= formatRupiah($item['harga'] ?? 0) ?></strong>
                                <span class="book-stock">Stok: <?= (int)($item['stok'] ?? 0) ?></span>
                            </div>

                            <a href="Detail.php?id=<?= (int)$item['id'] ?>" class="detail-link">
                                Lihat Detail <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <span class="empty-icon" aria-hidden="true">⌕</span>
                <h3><?= $keyword !== '' ? 'Buku tidak ditemukan' : 'Koleksi sedang disiapkan' ?></h3>
                <p>
                    <?= $keyword !== ''
                        ? 'Coba gunakan kata kunci lain untuk menemukan buku.'
                        : 'Silakan kembali lagi nanti untuk melihat koleksi buku kami.' ?>
                </p>
            </div>
        <?php endif; ?>
    </section>

    <!-- ================= INSPIRASI ================= -->
    <section class="inspiration-section" id="inspirasi">
        <div class="inspiration-inner">
            <div class="inspiration-mark" aria-hidden="true">✦</div>
            <span class="section-kicker light-kicker">LEBIH DARI SEKADAR MEMBACA</span>
            <h2>Temukan inspirasi<br>di setiap <em>halaman.</em></h2>
            <p>
                Sebuah buku dapat menghadirkan sudut pandang baru,
                memperluas imajinasi, dan mengajak kita melihat dunia
                dengan cara yang berbeda.
            </p>
            <a href="#koleksi" class="button button-light">
                Temukan Buku <span aria-hidden="true">→</span>
            </a>
        </div>
        <div class="inspiration-decoration decoration-one"></div>
        <div class="inspiration-decoration decoration-two"></div>
    </section>

    <!-- ================= RUANG MEMBACA ================= -->
    <section class="section reading-section" id="ruang-membaca">
        <div class="reading-visual">
            <div class="reading-card">
                <span class="reading-quote-mark">“</span>
                <p>Di antara halaman, kita menemukan kemungkinan yang tak terbatas.</p>
                <span class="reading-quote-line"></span>
                <span class="reading-quote-caption">PUSTAKA NUSA</span>
            </div>
            <div class="reading-orbit orbit-one"></div>
            <div class="reading-orbit orbit-two"></div>
        </div>

        <div class="reading-copy">
            <span class="section-kicker">RUANG UNTUK BERTUMBUH</span>
            <h2>Ruang Membaca,<br><span>Ruang Menjelajah.</span></h2>
            <p>
                Pustaka Nusa hadir untuk menemani perjalanan membaca,
                dari menemukan pengetahuan baru hingga menikmati cerita
                yang membekas di hati.
            </p>
            <a href="#koleksi" class="text-link">
                Mulai menjelajah koleksi <span aria-hidden="true">→</span>
            </a>
        </div>
    </section>
</main>

<!-- ================= FOOTER ================= -->
<footer class="site-footer">
    <div class="footer-inner">
        <a href="Index.php" class="footer-brand">
            <span class="footer-brand-icon" aria-hidden="true">▤</span>
            Pustaka <strong>Nusa</strong>
        </a>
        <p>Temukan cerita, temukan makna.</p>
        <span class="footer-copyright">© <?= date('Y') ?> Pustaka Nusa. Semua hak dilindungi.</span>
    </div>
</footer>

</body>
</html>
