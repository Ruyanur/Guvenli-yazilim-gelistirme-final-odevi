<?php
// Veritabanı bağlantısını gerçekleştir
$servername = "localhost";
$username = "root";
$password = "abc123";
$dbname = "user_management";

// Bağlantıyı oluştur
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

// Kullanıcı ID'sini al ve güvenli bir şekilde işle
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Kullanıcıyı sil
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Ürün başarıyla silindi";
    } else {
        echo "Ürün silinirken bir hata oluştu: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Geçersiz ürün ID'si";
}

$conn->close();
?>
