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
   
