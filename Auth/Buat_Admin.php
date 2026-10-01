
<?php
require_once __DIR__ . '/../Config/Database.php';

$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($nama === '' || $username === '' || $password === '') {
        $pesan = 'Semua kolom wajib diisi.';
    } elseif (strlen($password) < 8) {
        $pesan = 'Password minimal 8 karakter.';
    } else {
        $cek = $pdo->prepare(
            "SELECT id FROM admin WHERE username = :username"
        );
        $cek->execute(['username' => $username]);

        if ($cek->fetch()) {
            $pesan = 'Username sudah digunakan.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare(
                "INSERT INTO admin (nama, username, password)
                 VALUES (:nama, :username, :password)"
            );

            $stmt->execute([
                'nama' => $nama,
                'username' => $username,
                'password' => $hash
            ]);

            $pesan = 'Akun admin berhasil dibuat. Silakan login.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Admin</title>
</head>
<body>
    <h2>Buat Akun Admin Pustaka Nusa</h2>

    <?php if ($pesan !== ''): ?>
        <p><?= htmlspecialchars($pesan) ?></p>
    <?php endif; ?>

    <form method="POST">
        <p>
            <label>Nama</label><br>
            <input type="text" name="nama" required>
        </p>
        <p>
            <label>Username</label><br>
            <input type="text" name="username" required>
        </p>
        <p>
            <label>Password (minimal 8 karakter)</label><br>
            <input type="password" name="password" required minlength="8">
        </p>
        <button type="submit">Buat Akun</button>
    </form>
</body>
</html>
