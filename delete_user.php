<?php
// Veritabanı bağlantısını gerçekleştir
$servername = "localhost";
$username = "root";
$password = "abc123";
$dbname = "user_management";

$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

// Kullanıcı ID'sini al ve güvenli bir şekilde işle
if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $user_id = (int) $_GET['user_id'];

    // Kullanıcıyı sil
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute() === TRUE) {
        echo "Kullanıcı başarıyla silindi";
    } else {
        echo "Kullanıcı silinirken bir hata oluştu: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Geçersiz kullanıcı ID'si";
}

$conn->close();
?>
