<?php
// Veritabanı bağlantısı
$conn = mysqli_connect("localhost", "root", "abc123", "user_management");

// Bağlantı kontrolü
if (!$conn) {
    die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
}

// Formdan e-posta ve yeni şifre alınması
if(isset($_POST['email']) && isset($_POST['new_password'])) {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];

    // E-postaya sahip kullanıcıyı veritabanında kontrol et
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($result) > 0) {
        // E-posta adresi bulundu, yeni şifreyi veritabanını güncelle
        $update_query = "UPDATE users SET password='$new_password' WHERE email='$email'";
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            echo "Yeni şifreniz başarıyla güncellendi.";
        } else {
            echo "Şifre güncelleme işlemi başarısız oldu.";
        }
    } else {
        echo "Bu e-posta adresine sahip bir kullanıcı bulunamadı.";
    }
}

// Veritabanı bağlantısını kapat
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şifremi Unuttum</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h2 {
            color: #ff007f;
        }

        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #ff007f;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #cc005f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Şifremi Unuttum</h2>
        <form action="" method="POST">
            <label for="email">E-posta Adresiniz:</label><br>
            <input type="email" id="email" name="email" required><br><br>
            <label for="new_password">Yeni Şifre:</label><br>
            <input type="password" id="new_password" name="new_password" required><br><br>
            <input type="submit" value="Şifreyi Güncelle">
        </form>
    </div>
</body>
</html>


<!--php
// Veritabanı bağlantısı
$conn = mysqli_connect("localhost", "root", "abc123", "user_management");

// Bağlantı kontrolü
//if (!$conn) {
//    die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
//}

// Formdan e-posta ve yeni şifre alınması
if(isset($_POST['email']) && isset($_POST['new_password'])) {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];

    // E-postaya sahip kullanıcıyı veritabanında kontrol et
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($result) > 0) {
        // E-posta adresi bulundu, yeni şifreyi veritabanını güncelle
//$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $conn ="UPDATE users SET password='$password' WHERE email='$email'";

        echo "Yeni şifreniz başarıyla güncellendi.";
    } else {
        echo "Bu e-posta adresine sahip bir kullanıcı bulunamadı.";
    }
}

// Veritabanı bağlantısını kapat
//mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şifremi Unuttum</title>
</head>
<body>
    <h2>Şifremi Unuttum</h2>
    <form action="" method="POST">
        <label for="email">E-posta Adresiniz:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <label for="new_password">Yeni Şifre:</label><br>
        <input type="password" id="new_password" name="new_password" required><br><br>
        <input type="submit" value="Şifreyi Güncelle">
    </form>
</body>
</html>
