<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

require 'sqlite.php';
$db = new Database();

// Arama terimini al
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Veritabanında ürünleri adlarına göre ara
$products = $db->fetchAll("SELECT * FROM products WHERE name LIKE :search_query", ['search_query' => "%$search_query%"]);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Arama Sonuçları</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Arama Sonuçları</h1>
        <p>Aradığınız kelime: <?php echo htmlspecialchars($search_query); ?></p>
        <table>
            <tr>
                <th>Resim</th>
                <th>İsim</th>
                <th>Fiyat</th>
                <th>Açıklama</th>
            </tr>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Ürün Resmi"></td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo htmlspecialchars($product['price']); ?> TL</td>
                    <td><?php echo htmlspecialchars($product['description']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <a href="index.php" class="button">Ana Sayfaya Dön</a>
    </div>
</body>
</html>
