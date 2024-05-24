<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

require 'sqlite.php';
$db = new Database();

$products = $db->fetchAll('SELECT * FROM products');
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Butik</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Ürünler</h1>
        <?php if ($_SESSION['user']['role'] == 'admin' || $_SESSION['user']['role'] == 'editor'): ?>
            <a href="add.php" class="button">Yeni Ürün Ekle</a>
        <?php endif; ?>
        <table>
            <tr>
                <th>Resim</th>
                <th>İsim</th>
                <th>Fiyat</th>
                <th>Açıklama</th>
                <th>İşlemler</th>
            </tr>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Ürün Resmi"></td>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['price']); ?> TL</td>
                <td><?php echo htmlspecialchars($product['description']); ?></td>
                <td>
                    <?php if ($_SESSION['user']['role'] == 'admin' || $_SESSION['user']['role'] == 'editor'): ?>
                        <a href="edit.php?id=<?php echo $product['id']; ?>">Düzenle</a>
                    <?php endif; ?>
                    <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                        <a href="delete.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Bu ürünü silmek istediğinizden emin misiniz?');">Sil</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
