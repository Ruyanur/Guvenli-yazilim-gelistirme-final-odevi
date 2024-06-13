
<!-- anasayfa.php -->
<?php
session_start();
require __DIR__ . '/session_functions.php';

$conn = mysqli_connect("localhost", "root", "abc123", "user_management");
include 'auth.php';
requireAuth();

$username = $_SESSION['user_role'];
if (!isset($_SESSION['username'])) {
    header("Location: giris.php");
    exit();
}


    $username = $_SESSION['username'];
    $yas = $_SESSION ["yas"];
    $meslek = $_SESSION["meslek"];
    $hobiler = $_SESSION["hobiler"];
    $email = $_SESSION["email"];

    if (!checkSessionTimeout()) {
        header('Location: giris.php');
        exit();
    }
    
    // Oturum süresini hesaplayalım
    $login_time = $_SESSION['login_time'];
    $current_time = time();
    $session_duration = $current_time - $login_time;
    
    $hours = floor($session_duration / 3600);
    $minutes = floor(($session_duration % 3600) / 60);
    $seconds = $session_duration % 60;
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ana Sayfa</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f7f6;
            margin: 0;
            color: #333;
        }
        header {
            background-color: #ff6f61;
            color: white;
            padding: 20px;
            text-align: center;
        }
        nav ul {
            background-color: #ffafbd;
            list-style-type: none;
            padding: 10px;
            text-align: center;
            margin: 0;
        }
        nav ul li {
            display: inline;
            margin: 0 15px;
        }
        nav ul li a {
            text-decoration: none;
            color: white;
            font-weight: bold;
        }
        nav ul li a:hover {
            text-decoration: underline;
        }
        main {
            padding: 20px;
        }
        main section {
            margin-bottom: 20px;
            background-color: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        footer {
            background-color: #ff6f61;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        .profile-image {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 20px;
        }
        .profile-info, .contact-info {
            text-align: left;
        }
        .content-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .profile-info p, .contact-info p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <header>
    
   <h1>Hoşgeldiniz, <?php echo isset($_GET['username']) ? htmlspecialchars($_GET['username'], ENT_QUOTES, 'UTF-8') : htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></h1>

    <!--<h1>Hoşgeldiniz,<php echo $_GET['username']; ?></h1>-->
    <!--<h1>Hoşgeldiniz, <php echo $username; ?>!</h1>-->
       <!-- <h1>Hoşgeldiniz, <php echo htmlspecialchars($username); ?>!</h1>-->
    </header>
    <nav>
    <ul>
                <li><a href="anasayfa.php">Ana Sayfa</a></li>
                <!--<li><a href="dashboard.php">Sayfa</a></li> -->
                <!--<li><a href="yöneticisayfasi.php">Yönetici sayfası</a></li> -->
                <li><a href="editor.php">Editor</a></li> 
                <li><a href="admin.php">Admin</a></li> 
                <li><a href="urunler.php">Ürün Ekle</a></li>
                <li><a href="about.php">Hakkımızda</a></li>
                <li><a href="contact.php">İletişim</a></li>
                <li><a href="ajax_search.php">Ürün Ara</a></li>
                <li><a href="cikis.php">Çıkış Yap</a></li>
            </ul>
    </nav>
    <main>
        <div class="content-wrapper">
            <section>
                <h2>Profilim</h2>
                <img src="profil_resmi.jpeg" alt="Profil Resmi" class="profile-image">
                <div class="profile-info">
                <!--<p><strong>Ad:</strong> <php echo $username; ?></p>
                    <p><strong>Yaş:</strong> <php echo $yas; ?></p>
                    <p><strong>Meslek:</strong> <php echo $meslek; ?></p>
                    <p><strong>Hobiler:</strong><php echo $hobiler; ?></p>-->
                    <p><strong>Ad:</strong> <?php echo htmlspecialchars($username); ?>
                    <p><strong>Yaş:</strong> <?php echo htmlspecialchars($yas); ?>
                    <p><strong>Meslek:</strong> <?php echo htmlspecialchars($meslek); ?></p>
                    <p><strong>Hobiler:</strong><?php echo htmlspecialchars($hobiler); ?></p> 
<!--PHP'deki htmlspecialchars() fonksiyonu, özel karakterleri HTML varlıklarına dönüştürmek için kullanılır. 
Bu, özellikle kullanıcı tarafından oluşturulan içeriği bir web sayfasında görüntülerken  (XSS) saldırılarını
önlemek için önemlidir. HTML'de özel anlam taşıyan <, >, & ve " gibi karakterleri sırasıyla &lt;, &gt;, &amp; ve &quot; 
HTML varlıklarına dönüştürerek htmlspecialchars(), bu karakterlerin metin olarak işlenmesini sağlar.-->
                </div>
            </section>
            <section>
                <h2>Hakkımda</h2>
                <p>Merhaba! Ben <?php echo $username; ?>. 5 yıldır yazılım geliştirme alanında çalışıyorum. 
                 Bu süre zarfında birçok farklı projede yer aldım ve çeşitli teknolojilerle çalışma fırsatı buldum.
                Boş zamanlarımda açık kaynak projelere katkıda bulunmayı ve yeni diller öğrenmeyi seviyorum.</p>
                <!--<p>Merhaba! Ben <php echo htmlspecialchars($username); ?>. 5 yıldır yazılım geliştirme alanında çalışıyorum. Bu süre zarfında birçok farklı projede yer aldım ve çeşitli teknolojilerle çalışma fırsatı buldum. Boş zamanlarımda açık kaynak projelere katkıda bulunmayı ve yeni diller öğrenmeyi seviyorum.</p>-->
            </section>
            <section>
                <h2>İletişim</h2>
                <div class="contact-info">
                <!--<p><strong>Email:</strong> <php echo $email; ?></p>-->
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                    <p><strong>Telefon:</strong> +90 123 456 7890</p>
                    <p><strong>Adres:</strong> İstanbul, Türkiye</p>
                    <p>Benimle iletişime geçmek için yukarıdaki bilgileri kullanabilirsiniz. Sorularınız veya işbirliği tekliflerinizi bekliyorum.</p>
                </div>
            </section>
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>Session duration: <?php echo sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); ?></p>
    <a href="cikis.php">Logout</a>
        </div>
    </main>
    <footer>
        <p>2024 Benim Web Sitem</p>
    </footer>
</body>
</html>