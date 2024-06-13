<?php
session_start();
$conn = mysqli_connect("localhost", "root", "abc123", "user_management");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $urun_adi = $_POST['urun_adi'];
    $fiyat = $_POST['fiyat'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];
    $aciklama = $_POST['aciklama'];
    $eklenme_tarihi = $_POST['eklenme_tarihi'];

    // Güncelleme sorgusu
    $sql = "UPDATE products SET urun_adi='$urun_adi', fiyat='$fiyat', kategori='$kategori', stok='$stok', aciklama='$aciklama', eklenme_tarihi='$eklenme_tarihi' WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "Güncelleme başarılı.";
    } else {
        echo "Hata: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
