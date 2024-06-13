<?php
// Veritabanı bağlantısı
$conn = mysqli_connect("localhost", "root", "abc123", "user_management");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Parolayı hashle
    $role = $_POST['role'];
    $email = $_POST['email'];
    $yas = $_POST['yas'];
    $meslek = $_POST['meslek'];
    $hobiler = $_POST['hobiler'];

    // Veritabanında aynı rolde kaç kullanıcı olduğunu kontrol et
    $sql = "SELECT COUNT(*) AS count FROM users WHERE role = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $role);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Eğer admin veya editor ise ve o rolde zaten bir kullanıcı varsa hata mesajı göster
    if (($role == 'admin' || $role == 'editor') && $count > 0) {
        echo "Sadece bir $role kullanıcısı olabilir.";
    } else {
        $sql = "INSERT INTO users (username, password, role, email, yas, meslek, hobiler) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssiss", $username, $password, $role, $email, $yas, $meslek, $hobiler);
        if (mysqli_stmt_execute($stmt)) {
            echo "Kullanıcı başarıyla eklendi.";
        } else {
            echo "Hata: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}
?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Hemen Kayıt Ol!</title>
    <style>
        body {
            background: linear-gradient(to right, #ffafbd, #ffc3a0);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            margin: 0;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h2 {
            margin-bottom: 20px;
            color: #ff6f61;
        }
        label {
            display: block;
            margin: 15px 0 5px;
            text-align: left;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ff6f61;
            border-radius: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #ff6f61;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #ff4d4d;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
            margin-top: 20px;
        }
        nav ul li {
            display: inline;
            margin: 0 10px;
        }
        nav ul li a {
            text-decoration: none;
            color: #ff6f61;
            border-bottom: 2px solid transparent;
            transition: border-bottom 0.3s;
        }
        nav ul li a:hover {
            border-bottom: 2px solid #ff6f61;
        }
        .error {
            color: #ff4d4d;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<section id="content" class="container">
    <h2>Hesap Oluştur</h2>
    <form action="kayit.php" method="post">
        <div class="form-group">
            <input name='username' type="text" placeholder="Kullanıcı Adı" required class="form-control">
        </div>
        <div class="form-group">
            <input name='password' type="password" placeholder="Şifre" required class="form-control">
        </div>
        <div class="form-group">
            <input name='email' type="email" placeholder="E-posta" required class="form-control">
        </div>
        <div class="form-group">
            <input name='yas' type="text" placeholder="Yaş" class="form-control">
        </div>
        <div class="form-group">
            <input name='meslek' type="text" placeholder="Meslek" class="form-control">
        </div>
        <div class="form-group">
            <textarea name='hobiler' placeholder="Hobiler" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="role">Rol:</label>
            <select name="role" id="role">
                <option value="admin">Admin</option>
                <option value="editor">Editor</option>
                <option value="viewer">Viewer</option>
               
            </select>
        </div>
        <button type="submit" class="btn btn-lg btn-primary btn-block">Kayıt ol</button>
    </form>
    <div class="line line-dashed"></div>
    <p class="text-muted text-center"><small>Zaten hesabınız var mı?</small></p>
    <a href="giris.php" class="btn btn-lg btn-default btn-block">Giriş yap</a>
</section>


</body>
</html>