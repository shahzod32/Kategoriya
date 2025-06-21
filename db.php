<?php
$conn = new mysqli("localhost", "root", "", "crud_products");
if ($conn->connect_error) {
    die("Ulanishda xato: " . $conn->connect_error);
}
?>
