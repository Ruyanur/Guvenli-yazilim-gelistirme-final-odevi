<?php
session_start();
$conn = mysqli_connect("localhost", "root", "abc123", "user_management");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $yas = $_POST['yas'];
    $meslek = $_POST['meslek'];
    $hobiler = $_POST['hobiler'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Güncelleme sorgusu
    $sql = "UPDATE users SET username='$username', password='$password', yas='$yas', meslek='$meslek', hobiler='$hobiler', email='$email', role='$role' WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "Güncelleme başarılı.";
    } else {
        echo "Hata: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
