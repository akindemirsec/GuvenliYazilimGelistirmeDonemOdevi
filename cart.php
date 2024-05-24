<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Sepetteki ürünleri al
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Sepet boşsa kullanıcıya bilgilendirme yap
if (empty($cart_items)) {
    $message = "Sepetinizde ürün bulunmamaktadır.";
} else {
    $message = null;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sepetim</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Sepetim</h1>
        <?php if ($message): ?>
            <p style="color: red;"><?php echo $message; ?></p>
        <?php else: ?>
            <table>
                <tr>
                    <th>Resim</th>
                    <th>İsim</th>
                    <th>Fiyat</th>
                    <th>Açıklama</th>
                    <th>İşlemler</th>
                </tr>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Ürün Resmi"></td>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['price']); ?> TL</td>
                        <td><?php echo htmlspecialchars($item['description']); ?></td>
                        <td>
                            <form action="remove_from_cart.php" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                <button type="submit">Sepetten Çıkar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
        <a href="index.php" class="button">Ana Sayfaya Dön</a>
    </div>
</body>
</html>
