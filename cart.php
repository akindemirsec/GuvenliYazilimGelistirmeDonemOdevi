
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

function calculateTotalPrice($cart_items) {
    $total_price = 0;
    foreach ($cart_items as $item) {
        $total_price += $item['price'];
    }
    return $total_price;
}

// Sepetteki ürünleri al
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Sepet boşsa kullanıcıya bilgilendirme yap
if (empty($cart_items)) {
    $message = "Sepetinizde ürün bulunmamaktadır.";
} else {
    // Sepetin toplam fiyatını hesapla
    $total_price = calculateTotalPrice($cart_items);
    
    // İndirim kuponlarını uygula
    $discount = isset($_SESSION['discount']) ? $_SESSION['discount'] : 0;
    
    // Ödenecek toplam tutarı hesapla
    $final_price = $total_price - $discount;
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
        <?php if (isset($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Resim</th>
                        <th>İsim</th>
                        <th>Fiyat</th>
                        <th>Açıklama</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
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
                </tbody>
            </table>
            <div class="cart-summary">
                <p>Toplam Fiyat: <?php echo $total_price; ?> TL</p>
                <p>İndirim: <?php echo $discount; ?> TL</p>
                <p>Ödenecek Tutar: <?php echo $final_price; ?> TL</p>
            </div>
            <form action="apply_coupon.php" method="post" class="coupon-form">
                <label for="coupon_code">İndirim Kuponu:</label>
                <input type="text" id="coupon_code" name="coupon_code">
                <button type="submit">Kuponu Uygula</button>
            </form>
        <?php endif; ?>
        <nav>
            <a href="index.php" class="button">Ana Sayfaya Dön</a>
        </nav>
    </div>
</body>
</html>
