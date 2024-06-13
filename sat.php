<?php
// Veritabanı bağlantısı
$conn = mysqli_connect("localhost", "root", "abc123", "user_management");

// Bağlantı kontrolü
if (!$conn) {
    die("Veritabanına bağlanırken hata oluştu: " . mysqli_connect_error());
}

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Güvenlik için girişleri temizle
    $kullanici_id = mysqli_real_escape_string($conn, $_POST['kullanici_id']);
    $urun_id = mysqli_real_escape_string($conn, $_POST['urun_id']);

    // Satın alma sorgusu
    $satin_al_query = "INSERT INTO satin_almalar (kullanici_id, urun_id, satinalma_tarihi) VALUES ('$kullanici_id', '$urun_id', NOW())";

    // Satın alma sorgusunu çalıştır
    if (mysqli_query($conn, $satin_al_query)) {
        // Satın alınan ürünün stok sayısını azalt
        $stok_sorgu = mysqli_query($conn, "SELECT stok FROM products WHERE id = '$urun_id'");
        if ($stok_sorgu) {
            if (mysqli_num_rows($stok_sorgu) > 0) {
                $urun = mysqli_fetch_assoc($stok_sorgu);
                $stok = $urun['stok'];

                if ($stok > 0) {
                    $stok--;

                    // Stok güncelleme sorgusu
                    $stok_guncelle_query = "UPDATE products SET stok = '$stok' WHERE id = '$urun_id'";
                    mysqli_query($conn, $stok_guncelle_query);

                    // Satın almanın başarılı olduğu sayfaya yönlendir
                    header("Location: satın_alma_onayı.php");
                    exit();
                } else {
                    echo "Üzgünüz, bu ürün stokta bulunmamaktadır.";
                }
            } else {
                echo "Ürün bulunamadı veya stok bilgisi alınamadı.";
            }
        } else {
            echo "Stok sorgusu başarısız oldu.";
        }
    } else {
        echo "Satın alma işlemi sırasında bir hata oluştu.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satın Alma Sayfası</title>
</head>
<body>
    <h2>Ürün Satın Alma Formu</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="kullanici_id">Kullanıcı ID:</label><br>
        <input type="text" name="kullanici_id" id="kullanici_id" required><br><br>
        <label for="urun_id">Ürün ID:</label><br>
        <input type="text" name="urun_id" id="urun_id" required><br><br>
        <button type="submit">Satın Al</button>
    </form>
</body>
</html>
