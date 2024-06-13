<?php
session_start();
header('X-Frame-Options: SAMEORIGIN');
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Güvensiz bağlantı ve sorgu (SQL Injection'a açık)
    $conn = mysqli_connect("localhost", "root", "abc123", "user_management");
    $query = "SELECT *FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
            $_SESSION['login_time'] = time();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['yas'] = $user['yas'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['meslek'] = $user['meslek'];
            $_SESSION['hobiler'] = $user['hobiler'];
        header("Location: anasayfa.php");
        exit();
    } else {
        echo "Kullanıcı adı veya şifre hatalı.";
    }
    
}
?>
<!--php
session_start();

try {
    $pdo = new PDO("mysql:host=localhost;dbname=user_management", "root", "abc123");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "<div class='error'>Database connection failed: " . $e->getMessage() . "</div>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['yas'] = $user['yas'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['meslek'] = $user['meslek'];
            $_SESSION['hobiler'] = $user['hobiler'];
            
            header("Location: anasayfa.php");
            exit;
        } else {
            echo "<div class='error'>Kullanıcı adı veya şifre yanlış.</div>";
        }
    } catch (PDOException $e) {
        echo "<div class='error'>Bir hata oluştu: " . $e->getMessage() . "</div>";
    }
}
-->

       
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
 

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
    
    <script>
        document.getElementById('avatar').src = '<?php echo htmlspecialchars($_GET['avatar'], ENT_QUOTES, 'UTF-8'); ?>';
        document.getElementById('username').textContent = '<?php echo htmlspecialchars($_GET['username'], ENT_QUOTES, 'UTF-8'); ?>';
        //<h1>SALDIRI YAPILDIIIII!!!!!!</h1>
        
        
   
    </script>
</head>

<body>

    <div class="container">
        <h2>Giriş Yap</h2>
        
        <form action="giris.php" method="post">
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Şifre:</label>
            <input type="password" id="password" name="password" required>
            
            <button  type="submit">Giriş Yap</button>
        </form>
        
        <nav>
            <ul>
           

                <li><a href="sifreunut.php">Şifrenimi Unuttun!!!!!!!!</a></li>
            </ul>
        </nav>
        <nav>
            <ul>
                <li><a href="kayit.php">Kayıt Yap</a></li>
            </ul>
        </nav>
       
    </div>
   
</body>
</html>
