
<?php
session_start();

if (isset($_SESSION['admin_id'])) {
    header("Location: ../Index.php");
    exit;
}

$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Pustaka Nusa</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f3f5f8;
            font-family: Arial, sans-serif;
        }
        .login-box {
            width: 100%;
            max-width: 400px;
            padding: 32px;
            background: white;
            border-radius: 14px;
            box-shadow: 0 8px 28px rgba(0,0,0,.08);
        }
        h1 { color: #16483d; margin-top: 0; }
        label { display: block; margin: 16px 0 7px; }
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccd4d1;
            border-radius: 7px;
            font-size: 15px;
        }
        button {
            width: 100%;
            margin-top: 22px;
            padding: 12px;
            border: 0;
            border-radius: 7px;
            background: #16483d;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .error {
            padding: 10px;
            color: #9f2424;
            background: #fff0f0;
            border-radius: 6px;
        }
        .back { display: block; margin-top: 18px; color: #16483d; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>Login Admin</h1>
        <p>Masuk untuk mengelola buku Pustaka Nusa.</p>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="Proses_Login.php" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username"
                   required autocomplete="username">

            <label for="password">Password</label>
            <input type="password" id="password" name="password"
                   required autocomplete="current-password">

            <button type="submit">Masuk</button>
        </form>

        <a class="back" href="../Index.php">Kembali ke halaman utama</a>
    </div>
</body>
</html>
