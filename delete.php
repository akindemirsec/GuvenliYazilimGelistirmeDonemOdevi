<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

require 'sqlite.php';
$db = new Database();

$id = $_GET['id'];

$db->query('DELETE FROM products WHERE id = :id', ['id' => $id]);

header('Location: index.php');
exit;
?>
