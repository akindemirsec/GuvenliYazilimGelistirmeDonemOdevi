<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

require 'sqlite.php';
$db = new Database();

// Ürünleri veritabanından al
$products = $db->fetchAll('SELECT * FROM products');

$user = $_SESSION['user'];

// Sepete eklendiğine dair mesajı kontrol et
$message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
unset($_SESSION['message']); // Mesajı temizle
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ana Sayfa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Ana Sayfa</h1>
        
        <!-- Arama Formu -->
        <form action="search.php" method="GET">
            <label for="search">Ürün Ara:</label>
            <input type="text" id="search" name="search" placeholder="Ürün adı girin...">
            <button type="submit">Ara</button>
        </form>
        
        <?php if ($_SESSION['user']['role'] == 'admin' || $_SESSION['user']['role'] == 'editor'): ?>
            <a href="add.php" class="button">Yeni Ürün Ekle</a>
        <?php endif; ?>
        <a href="profile.php" class="button">Profil</a>
        <a href="cart.php" class="button">Sepetim</a>
        <?php if ($message): ?>
            <p style="color: green;"><?php echo $message; ?></p>
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
                        <form action="add_to_cart.php" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit">Sepete Ekle</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
