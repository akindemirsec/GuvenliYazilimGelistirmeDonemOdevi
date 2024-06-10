<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

require 'sqlite.php';
$db = new Database();

$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_image'])) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
    
    // Dosya yükleme işlemi (kontrol yapılmıyor)
    move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);

    // Profil fotoğrafını güncelle
    $db->query("UPDATE users SET profile_image = :profile_image WHERE id = :id", [
        'profile_image' => $target_file,
        'id' => $user['id']
    ]);

    // Kullanıcı oturumunu güncelle
    $_SESSION['user']['profile_image'] = $target_file;
    header('Location: profile.php');
    exit;
}
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
        <div class="profile">
            <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profil Fotoğrafı" style="width: 300px; height: 300px;">
            <h1><?php echo htmlspecialchars($user['username']); ?></h1>
            <form action="profile.php" method="post" enctype="multipart/form-data">
                <label for="profile_image">Profil Fotoğrafını Değiştir (300x300):</label>
                <input type="file" name="profile_image" id="profile_image" required>
                <button type="submit">Yükle</button>
            </form>
        </div>
        <nav>
            <a href="index.php" class="button">Ana Sayfaya Dön</a>
            <a href="logout.php" class="button">Çıkış Yap</a>
        </nav>
    </div>
</body>
</html>
