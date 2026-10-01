
<?php
session_start();
require_once __DIR__ . '/../Config/Database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: Login.php");
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    $_SESSION['login_error'] = 'Username dan password wajib diisi.';
    header("Location: Login.php");
    exit;
}

$stmt = $pdo->prepare(
    "SELECT id, nama, username, password
     FROM admin
     WHERE username = :username
     LIMIT 1"
);
$stmt->execute(['username' => $username]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($admin && password_verify($password, $admin['password'])) {
    session_regenerate_id(true);

    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_nama'] = $admin['nama'];
    $_SESSION['admin_username'] = $admin['username'];

    header("Location: ../Index.php");
    exit;
}

$_SESSION['login_error'] = 'Username atau password salah.';
header("Location: Login.php");
exit;
