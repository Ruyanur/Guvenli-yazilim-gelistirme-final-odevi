<?php
session_start();
$conn = mysqli_connect("localhost", "root", "abc123", "user_management");

if ($_SESSION['user_role'] == 'viewer' || $_SESSION['user_role'] == 'admin') {
    echo "<script>alert('Bu sayfaya erişim izniniz yok.'); window.location.href = 'anasayfa.php';</script>";
    exit;
}

// Kullanıcıları listeleme işlemi
$userResult = mysqli_query($conn, "SELECT * FROM users");
$users = mysqli_fetch_all($userResult, MYSQLI_ASSOC);

// Ürünleri listeleme işlemi
$productResult = mysqli_query($conn, "SELECT * FROM products");
$products = mysqli_fetch_all($productResult, MYSQLI_ASSOC);

// Kullanıcı silme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    mysqli_query($conn, "DELETE FROM users WHERE id = $user_id");
    header("Location: editor.php");
    exit;
}

// Kullanıcı güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $role = $_POST['role'];
    $yas = $_POST['yas'];
    $meslek = $_POST['meslek'];
    $hobiler = $_POST['hobiler'];
    $email = $_POST['email'];
    mysqli_query($conn, "UPDATE users SET  yas = '$yas', meslek = '$meslek', hobiler = '$hobiler', email = '$email', role = '$role' WHERE id = $user_id");
    header("Location: editor.php");
    exit;
}

// Ürün silme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];
    mysqli_query($conn, "DELETE FROM products WHERE id = $product_id");
    header("Location: editor.php");
    exit;
}

// Ürün güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $product_id = $_POST['product_id'];
    $fiyat = $_POST['fiyat'];
    $stok = $_POST['stok'];
    mysqli_query($conn, "UPDATE products SET  fiyat = '$fiyat', stok = '$stok' WHERE id = $product_id");
    header("Location: editor.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editör Paneli</title>
    <style>
        /* Genel stil */
        th, td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #ff6f61;
            color: #fff;
        }

        td {
            background-color: #f9f9f9;
        }

        button {
            background-color: #ff6f61;
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: #ff5444;
            transform: translateY(-3px);
        }

        input[type="submit"], button[type="submit"] {
            background-color: #ff6f61;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        input[type="submit"]:hover, button[type="submit"]:hover {
            background-color: #ff5444;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <h1>Editör Paneli</h1>
    <p>Hoş geldiniz, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
    <a href="cikis.php">Çıkış Yap</a>

    <h2>Kullanıcılar</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Kullanıcı Adı</th>
            <th>Yetki Rolü</th>
            <th>Yaş</th>
            <th>Meslek</th>
            <th>Hobiler</th>
            <th>Email</th>
            <th>Yetki</th>
            <th>Güncelle</th>
            <th>Sil</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['password']; ?></td>
                <td><?php echo $user['yas']; ?></td>
                <td><?php echo $user['meslek']; ?></td>
                <td><?php echo $user['hobiler']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td> <select name="role">
            <option value="viewer" <?php if ($user['role'] === 'viewer') echo 'selected'; ?>>Viewer</option>
            <option value="editor" <?php if ($user['role'] === 'editor') echo 'selected'; ?>>Editor</option>
        </select></td>
                <td>
    <form action="" method="post"> <!-- Add form tag here -->
        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
        <input type="number" name="yas" value="<?php echo $user['yas']; ?>">
        <input type="text" name="meslek" value="<?php echo $user['meslek']; ?>">
        <input type="text" name="hobiler" value="<?php echo $user['hobiler']; ?>">
        <input type="email" name="email" value="<?php echo $user['email']; ?>">
        <select name="role">
            <option value="viewer" <?php if ($user['role'] === 'viewer') echo 'selected'; ?>>Viewer</option>
            <option value="editor" <?php if ($user['role'] === 'editor') echo 'selected'; ?>>Editor</option>
        </select>
        <button type="submit" name="update_user">Güncelle</button> <!-- Submit button for user update -->
    </form>
</td>

                <td>
                    <form action="" method="post">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <button type="submit" name="delete_user">Sil</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Ürünler</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Ürün Adı</th>
            <th>Fiyat</th>
            <th>Stok</th>
            <th>İşlem</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo $product['id']; ?></td>
                <td><?php echo $product['urun_adi']; ?></td>
                <td><?php echo $product['fiyat']; ?></td>
                <td><?php echo $product['stok']; ?></td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="text" name="fiyat" value="<?php echo $product['fiyat']; ?>">
                        <input type="number" name="stok" value="<?php echo $product['stok']; ?>">
                        <button type="submit" name="update_product">Güncelle</button>
                    </form>
                </td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit" name="delete_product">Sil</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>