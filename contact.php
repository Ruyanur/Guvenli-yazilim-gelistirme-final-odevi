<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>İletişim</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 1200px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            margin-top: 0;
        }

        nav ul {
            list-style: none;
            padding: 0;
            text-align: center;
        }

        nav ul li {
            display: inline;
            margin-right: 10px;
        }

        nav ul li a {
            text-decoration: none;
            color: #555;
            padding: 8px 15px;
            border-radius: 5px;
            background-color: #f5f5f5;
            transition: background-color 0.3s;
        }

        nav ul li a:hover {
            background-color: #e0e0e0;
        }

        form {
            margin-top: 20px;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        textarea,
        select {
            width: calc(100% - 24px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        input[type="submit"] {
            padding: 12px 20px;
            background: #4caf50;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background: #45a049;
        }

        .success-message {
            color: #4caf50;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>İletişim</h2>
        <nav>
            <ul>
                <li><a href="anasayfa.php">Ana Sayfa</a></li>
            </ul>
        </nav>
        
        <p>
           RÜYA NUR DURKUN
        </p>
        <p>
            Tel: 0505 210 5446
        </p>
        <p>
            E-mail: ruyanurdurkun06@gmail.com
        </p>
        <p>Bizimle iletişime geçmek için lütfen aşağıdaki formu doldurun:</p>
        <form method="post">
            <label for="name">Adınız:</label><br>
            <input type="text" id="name" name="name" required><br>
            <label for="email">E-posta:</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="message">Mesajınız:</label><br>
            <textarea id="message" name="message" required></textarea><br>
            <input type="submit" value="Gönder">
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];
            
            // Yorumları dosyaya ekleme
            $file = 'comments.txt';
            $current = file_get_contents($file);
            $current .= "<strong>Adı:</strong> " . $name . "<br>";
            $current .= "<strong>E-posta:</strong> " . $email . "<br>";
            $current .= "<strong>Mesaj:</strong> " . $message . "<br><br>";
            file_put_contents($file, $current);
            
            echo '<p class="success-message">Sayın ' . $name . ', mesajınız başarıyla gönderildi! Teşekkür ederiz.</p>';
        }
        ?>
        <!--php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
            $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');

            
            // Yorumları dosyaya ekleme
            $file = 'comments.txt';
            $current = file_get_contents($file);
            $current .= "<strong>Adı:</strong> " . $name . "<br>";
            $current .= "<strong>E-posta:</strong> " . $email . "<br>";
            $current .= "<strong>Mesaj:</strong> " . $message . "<br><br>";
            file_put_contents($file, $current);
            
            echo '<p class="success-message">Sayın ' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . ', mesajınız başarıyla gönderildi! Teşekkür ederiz.</p>';
         }
    -->
        <hr>
        <h3>Gönderilen Mesajlar:</h3>
        <?php
        // Dosyadaki yorumları okuma ve ekrana yazdırma
        $comments = file_get_contents('comments.txt');
        echo $comments;
        
        //echo htmlspecialchars($comments, ENT_QUOTES, 'UTF-8');


        ?>
        
    </div>
</body>
</html>
