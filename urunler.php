<?php
session_start();

$conn = mysqli_connect("localhost", "root", "abc123", "user_management");
// Kullanıcının ürünlerini getir
$kullanici_id = $_SESSION['user_id'];
$sql = "SELECT * FROM products WHERE kullanici_id = '$kullanici_id'";
$result = mysqli_query($conn, $sql);
$urunler = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Kullanıcının rolünü kontrol et
//if ($_SESSION['user_role'] == 'viewer') {
  //  echo "<script>alert('Bu sayfaya erişim izniniz yok.'); window.location.href = 'anasayfa.php';</script>";
//exit;
//}

// Yeni ürün ekleme
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ekle'])) {
    $urun_adi = $_POST['urun_adi'];
    $fiyat = $_POST['fiyat'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];
    $aciklama = $_POST['aciklama'];

    $sql = "INSERT INTO products (kullanici_id, urun_adi, fiyat, kategori, stok, aciklama) VALUES ('$kullanici_id', '$urun_adi', '$fiyat', '$kategori', '$stok', '$aciklama')";
    if (mysqli_query($conn, $sql)) {
        echo "Ürün başarıyla eklendi!";
    } else {
        echo "Hata: " . mysqli_error($conn);
    }
}

// Ürün silme
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sil'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM products WHERE id = '$id' AND kullanici_id = '$kullanici_id'";
    if (mysqli_query($conn, $sql)) {
        echo "Ürün başarıyla silindi!";
    } else {
        echo "Hata: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ürünler</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        h1, h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
            color: #333;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        form {
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        form label {
            display: block;
            margin-bottom: 10px;
            color: #555;
        }

        form input[type="text"],
        form input[type="number"],
        form textarea {
            width: calc(100% - 24px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<li><a href="anasayfa.php">Ana Sayfa</a></li>
<h2>Yeni Ürün Ekle</h2>
<form method="POST">
    <label for="urun_adi">Ürün Adı:</label>
    <input type="text" id="urun_adi" name="urun_adi" required>
    <br>
    <label for="fiyat">Fiyat:</label>
    <input type="number" step="0.01" id="fiyat" name="fiyat" required>
    <br>
    <label for="kategori">Kategori:</label>
    <input type="text" id="kategori" name="kategori">
    <br>
    <label for="stok">Stok:</label>
    <input type="number" id="stok" name="stok">
    <br>
    <label for="aciklama">Açıklama:</label>
    <textarea id="aciklama" name="aciklama"></textarea>
    <br>
    <input type="submit" name="ekle" value="Ekle">
</form>

<h1><?php echo $_SESSION['username']; ?>'nin Ürün Listesi</h1>
<table border="1">
    <tr>
        <th>Ürün Adı</th>
        <th>Fiyat</th>
        <th>Kategori</th>
        <th>Stok</th>
        <th>Açıklama</th>
        <th>Eklenme Tarihi</th>
        <th>İşlemler</th>
    </tr>
    <?php if (count($urunler) > 0) : ?>
        <?php foreach ($urunler as $row) : ?>
            <tr>
                <td><?php echo $row['urun_adi']; ?></td>
                <td><?php echo $row['fiyat']; ?></td>
                <td><?php echo $row['kategori']; ?></td>
                <td><?php echo $row['stok']; ?></td>
                <td><?php echo $row['aciklama']; ?></td>
                <td><?php echo $row['eklenme_tarihi']; ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="submit" name="sil" value="Sil">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="7">Hiç ürün bulunmamaktadır.</td>
        </tr>
    <?php endif; ?>
</table>
</body>
</html>


<!--php
session_start();
include 'config.php';
include 'auth.php';
requireAuth();

// Kullanıcının ürünlerini getir
$kullanici_id = $_SESSION['user_id'];
$sql = "SELECT * FROM products WHERE kullanici_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$kullanici_id]);
$urunler = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Kullanıcının rolünü kontrol et
if ($_SESSION['user_role'] == 'viewer') {
    echo "<script>alert('Bu sayfaya erişim izniniz yok.'); window.location.href = 'anasayfa.php';</script>";
    exit;
}

// Yeni ürün ekleme
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ekle'])) {
    $urun_adi = $_POST['urun_adi'];
    $fiyat = $_POST['fiyat'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];
    $aciklama = $_POST['aciklama'];

    $sql = "INSERT INTO products (kullanici_id, urun_adi, fiyat, kategori, stok, aciklama) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$kullanici_id, $urun_adi, $fiyat, $kategori, $stok, $aciklama])) {
        echo "Ürün başarıyla eklendi!";
    } else {
        echo "Hata: " . $stmt->errorInfo()[2];
    }
}

// Ürün silme
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sil'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM products WHERE id = ? AND kullanici_id = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$id, $kullanici_id])) {
        echo "Ürün başarıyla silindi!";
    } else {
        echo "Hata: " . $stmt->errorInfo()[2];
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ürünler</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        h1, h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
            color: #333;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        form {
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        form label {
            display: block;
            margin-bottom: 10px;
            color: #555;
        }

        form input[type="text"],
        form input[type="number"],
        form textarea {
            width: calc(100% - 24px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>


    <h2>Yeni Ürün Ekle</h2>
    <form method="POST">
        <label for="urun_adi">Ürün Adı:</label>
        <input type="text" id="urun_adi" name="urun_adi" required>
        <br>
        <label for="fiyat">Fiyat:</label>
        <input type="number" step="0.01" id="fiyat" name="fiyat" required>
        <br>
        <label for="kategori">Kategori:</label>
        <input type="text" id="kategori" name="kategori">
        <br>
        <label for="stok">Stok:</label>
        <input type="number" id="stok" name="stok">
        <br>
        <label for="aciklama">Açıklama:</label>
        <textarea id="aciklama" name="aciklama"></textarea>
        <br>
        <input type="submit" name="ekle" value="Ekle">
    </form>
    <h1><?php echo htmlspecialchars($_SESSION['username']); ?>'nin Ürün Listesi</h1>
    <table border="1">
        <tr>
            <th>Ürün Adı</th>
            <th>Fiyat</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Açıklama</th>
            <th>Eklenme Tarihi</th>
            <th>İşlemler</th>
        </tr>
        <?php if (count($urunler) > 0) : ?>
            <?php foreach ($urunler as $row) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['urun_adi']); ?></td>
                    <td><?php echo htmlspecialchars($row['fiyat']); ?></td>
                    <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                    <td><?php echo htmlspecialchars($row['stok']); ?></td>
                    <td><?php echo htmlspecialchars($row['aciklama']); ?></td>
                    <td><?php echo htmlspecialchars($row['eklenme_tarihi']); ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <input type="submit" name="sil" value="Sil">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="7">Hiç ürün bulunmamaktadır.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
