<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Profil</h1>
        <div class="profile">
            <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profil Fotoğrafı">
            <p>Kullanıcı Adı: <?php echo htmlspecialchars($user['username']); ?></p>
        </div>
        <a href="index.php" class="button">Ana Sayfaya Dön</a>
        <a href="logout.php" class="button">Çıkış Yap</a>
    </div>
</body>
</html>
