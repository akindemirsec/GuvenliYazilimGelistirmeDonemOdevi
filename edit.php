<?php
session_start();
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] != 'admin' && $_SESSION['user']['role'] != 'editor')) {
    header('Location: login.php');
    exit;
}

require 'sqlite.php';
$db = new Database();

$id = $_GET['id'];
$product = $db->fetch('SELECT * FROM products WHERE id = :id', ['id' => $id]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image'];

    $db->query('UPDATE products SET name = :name, price = :price, description = :description, image = :image WHERE id = :id', [
        'name' => $name,
        'price' => $price,
        'description' => $description,
        'image' => $image,
        'id' => $id
    ]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ürünü Düzenle</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Ürünü Düzenle</h1>
        <form action="" method="post">
            <label for="name">İsim:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            <label for="price">Fiyat:</label>
            <input type="number" step="0.01" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            <label for="description">Açıklama:</label>
            <textarea name="description" id="description"><?php echo htmlspecialchars($product['description']); ?></textarea>
            <label for="image">Resim URL'si:</label>
            <input type="text" name="image" id="image" value="<?php echo htmlspecialchars($product['image']); ?>">
            <button type="submit">Kaydet</button>
        </form>
        <a href="index.php" class="button">Geri Dön</a>
    </div>
</body>
</html>
