<?php
session_start();
require 'sqlite.php';
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Şifreyi düz metin olarak al
    $profile_image = '';

    // Profil fotoğrafı yükleme işlemi
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);
        $profile_image = $target_file;
    }

    // Kullanıcıyı veritabanına ekleme
    $success = $db->query('INSERT INTO users (username, password, profile_image) VALUES (:username, :password, :profile_image)', [
        'username' => $username,
        'password' => $password, // Şifreyi düz metin olarak kaydet
        'profile_image' => $profile_image
    ]);

    if ($success) {
        header('Location: login.php');
        exit;
    } else {
        $error = 'Kayıt başarısız oldu';
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Kayıt Ol</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="register.php" method="post" enctype="multipart/form-data">
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Şifre:</label>
            <input type="password" name="password" id="password" required>
            <label for="profile_image">Profil Fotoğrafı:</label>
            <input type="file" name="profile_image" id="profile_image" accept="image/*">
            <button type="submit">Kayıt Ol</button>
        </form>
        <a href="login.php" class="button">Giriş Yap</a>
    </div>
</body>
</html>
