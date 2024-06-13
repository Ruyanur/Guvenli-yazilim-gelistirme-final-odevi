<?php
session_start();
$conn = mysqli_connect("localhost", "root", "abc123", "user_management");

// Kullanıcı yetki kontrolü
if ($_SESSION['user_role'] == 'viewer' || $_SESSION['user_role'] == 'editor') {
    echo "<script>alert('Bu sayfaya erişim izniniz yok.'); window.location.href = 'anasayfa.php';</script>";
    exit;
}

// Kullanıcıları listeleme işlemi
if(isset($_GET['fetchUsers'])) {
    $userResult = mysqli_query($conn, "SELECT * FROM users");
    $users = mysqli_fetch_all($userResult, MYSQLI_ASSOC);
    $output = '<table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kullanıcı Adı</th>
                            <th>Şifre</th>
                            <th>Yaş</th>
                            <th>Meslek</th>
                            <th>Hobiler</th>
                            <th>E-posta</th>
                            <th>Yetki Rolü</th>
                            <th>Oturum Süresi</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>';

    foreach ($users as $user) {
        $output .= '<tr>
                        <td>' . $user['id'] . '</td>
                        <td><input type="text" name="username" value="' . $user['username'] . '"></td>
                        <td><input type="text" name="password" value="' . $user['password'] . '"></td>
                        <td><input type="number" name="yas" value="' . $user['yas'] . '"></td>
                        <td><input type="text" name="meslek" value="' . $user['meslek'] . '"></td>
                        <td><input type="text" name="hobiler" value="' . $user['hobiler'] . '"></td>
                        <td><input type="email" name="email" value="' . $user['email'] . '"></td>
                        <td>
                            <select name="role">
                                <option value="admin" ' . ($user['role'] === 'admin' ? 'selected' : '') . '>Admin</option>
                                <option value="viewer" ' . ($user['role'] === 'viewer' ? 'selected' : '') . '>Viewer</option>
                                <option value="editor" ' . ($user['role'] === 'editor' ? 'selected' : '') . '>Editor</option>
                            </select>
                        </td>
                        <td>' . calculateSessionDuration($user['login_time'], $user['logout_time']) . '</td>
                        <td>
                            <button onclick="editUser(this)">Düzenle</button>
                            <button onclick="deleteUser(' . $user['id'] . ')">Sil</button>
                            <button style="display: none;" onclick="saveUser(this, ' . $user['id'] . ')">Kaydet</button>
                        </td>
                    </tr>';
    }

    $output .= '</tbody></table>';
    echo $output;

    exit;
}

// Ürünleri listeleme işlemi
if(isset($_GET['fetchProducts'])) {
    $productResult = mysqli_query($conn, "SELECT * FROM products");
    $products = mysqli_fetch_all($productResult, MYSQLI_ASSOC);
    $output = '<table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ürün Adı</th>
                            <th>Fiyat</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Açıklama</th>
                            <th>Eklenme Tarihi</th>
                            <th>Tarihi Değiştir</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>';

    foreach ($products as $product) {
        $output .= '<tr>
                        <td>' . $product['id'] . '</td>
                        <td><input type="text" name="urun_adi" value="' . $product['urun_adi'] . '"></td>
                        <td><input type="number" name="fiyat" value="' . $product['fiyat'] . '"></td>
                        <td><input type="text" name="kategori" value="' . $product['kategori'] . '"></td>
                        <td><input type="number" name="stok" value="' . $product['stok'] . '"></td>
                        <td><input type="text" name="aciklama" value="' . $product['aciklama'] . '"></td>
                        <td>' . $product['eklenme_tarihi'] . '</td>
                        <td>
                            <input type="date" name="eklenme_tarihi" value="' . $product['eklenme_tarihi'] . '">
                        </td>
                        <td>
                            <button onclick="updateProduct(' . $product['id'] . ')">Güncelle</button>
                            <button onclick="deleteProduct(' . $product['id'] . ')">Sil</button>
                        </td>
                    </tr>';
    }

    $output .= '</tbody></table>';
    echo $output;

    exit;
}

// Oturum süresini hesaplama fonksiyonu
function calculateSessionDuration($login_time, $logout_time) {
    if ($login_time == null) {
        return "giriş yapılmadı";
    } elseif ($logout_time != null) {
        $session_duration = strtotime($logout_time) - strtotime($login_time); // Oturum süresini saniye cinsinden hesapla
        if ($session_duration >= 600) { // 600 saniye = 10 dakika
            return "Süre Doldu";
        } else {
            // Oturum süresini formatlayıp ekrana yazdır
            $hours = floor($session_duration / 3600);
            $minutes = floor(($session_duration % 3600) / 60);
            $seconds = $session_duration % 60;
            return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
        }
    } else {
        return "Oturum devam ediyor";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Yönetici Paneli</title>
    <style>
        /* Genel stil */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h1 {
            background-color: #ff6f61;
            color: #fff;
            padding: 20px;
            margin: 0;
        }
        a {
            color: #ff6f61;
            text-decoration: none;
            padding: 10px;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .data-table th,
        .data-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .data-table th {
            background-color: #f2f2f2;
        }
        .data-table tbody tr:hover {
            background-color: #f2f2f2;
        }
        .data-table input[type="text"],
        .data-table input[type="number"],
        .data-table input[type="email"],
        .data-table input[type="date"] {
            width: 100%;
            padding: 5px;
            box-sizing: border-box;
        }
        .data-table select {
            width: 100%;
            padding: 5px;
            box-sizing: border-box;
        }
        .data-table button {
            background-color: #ff6f61;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .data-table button:hover {
            background-color: #ff5444;
        }
    </style>
</head>
<body>
    <h1>Yönetici Paneli</h1>
    <div class="container">
        <p>Hoş geldiniz, <?php echo $_SESSION['username']; ?>!</p>
        <a href="anasayfa.php">Çıkış Yap</a>

        <h2>Kullanıcılar</h2>
        <div id="user-list"></div>

        <h2>Ürünler</h2>
        <div id="product-list"></div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            fetchUsers();
            fetchProducts();
        });

        function fetchUsers() {
            $.ajax({
                url: 'admin.php?fetchUsers=true',
                type: 'GET',
                success: function(response) {
                    $('#user-list').html(response);
                }
            });
        }

        function fetchProducts() {
            $.ajax({
                url: 'admin.php?fetchProducts=true',
                type: 'GET',
                success: function(response) {
                    $('#product-list').html(response);
                }
            });
        }

        function editUser(button) {
            var row = $(button).closest('tr');
            row.find('input').prop('readonly', false); // Inputları düzenlenebilir hale getir
            row.find('select').prop('disabled', false); // Selectleri düzenlenebilir hale getir
            row.find('button').toggle(); // Düzenle ve Sil butonlarını gizle, Kaydet butonunu göster
        }

        function saveUser(button, id) {
            var row = $(button).closest('tr');
            var username = row.find('input[name="username"]').val();
            var password = row.find('input[name="password"]').val();
            var yas = row.find('input[name="yas"]').val();
            var meslek = row.find('input[name="meslek"]').val();
            var hobiler = row.find('input[name="hobiler"]').val();
            var email = row.find('input[name="email"]').val();
            var role = row.find('select[name="role"]').val();

            $.ajax({
                url: 'update_user.php',
                type: 'POST',
                data: {
                    id: id,
                    username: username,
                    password: password,
                    yas: yas,
                    meslek: meslek,
                    hobiler: hobiler,
                    email: email,
                    role: role
                },
                success: function(response) {
                    alert('Kullanıcı güncellendi.');
                    fetchUsers();
                }
            });

            row.find('input').prop('readonly', true); // Inputları tekrar salt okunur yap
            row.find('select').prop('disabled', true); // Selectleri tekrar salt okunur yap
            row.find('button').toggle(); // Düzenle ve Sil butonlarını göster, Kaydet butonunu gizle
        }

        function deleteUser(user_id) {
    // Kullanıcıya onay al
    if (confirm("Kullanıcıyı silmek istediğinizden emin misiniz?")) {
        console.log('Deletion confirmed for user_id:', user_id);

        $.ajax({
            url: 'delete_user.php', // Deletion endpoint
            type: 'GET', // Request type
            data: { user_id: user_id }, // Data to send
            success: function(response) {
                console.log('Server response:', response);
                // Trim the response to remove any extra whitespace
                response = response.trim();
                
                // Check the response and provide feedback
                if (response === 'Kullanıcı başarıyla silindi') {
                    alert('Kullanıcı silindi.');
                    window.location.href = 'admin.php'; // Redirect upon success
                } else {
                    alert('Kullanıcı silinirken bir hata oluştu: ' + response);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                // Handle any errors from the server
                alert('Sunucu hatası: ' + error); 
            }
        });
    } else {
        console.log('Kullanıcı silme işlemi iptal edildi.');
    }
}

        function updateProduct(id) {
            var urun_adi = $('input[name="urun_adi"]').val();
            var fiyat = $('input[name="fiyat"]').val();
            var kategori = $('input[name="kategori"]').val();
            var stok = $('input[name="stok"]').val();
            var aciklama = $('input[name="aciklama"]').val();
            var eklenme_tarihi = $('input[name="eklenme_tarihi"]').val();

            $.ajax({
                url: 'update_product.php',
                type: 'POST',
                data: {
                    id: id,
                    urun_adi: urun_adi,
                    fiyat: fiyat,
                    kategori: kategori,
                    stok: stok,
                    aciklama: aciklama,
                    eklenme_tarihi: eklenme_tarihi
                },
                success: function(response) {
                    alert('Ürün güncellendi.');
                    fetchProducts();
                }
            });
        }

        
        function deleteProduct(id) {
    // Kullanıcıya onay al
    if (confirm("Ürünü silmek istediğinizden emin misiniz?")) {
        console.log('Deletion confirmed for product_id:', id);

        $.ajax({
            url: 'delete_product.php', // Corrected the endpoint
            type: 'GET', // Request type
            data: { id: id }, // Data to send
            success: function(response) {
                console.log('Server response:', response);
                // Trim the response to remove any extra whitespace
                response = response.trim();
                
                // Check the response and provide feedback
                if (response === 'ürün başarıyla silindi') {
                    alert('Ürün silindi.');
                    window.location.href = 'admin.php'; // Redirect upon success
                } else {
                    alert('Ürün silinirken bir hata oluştu: ' + response);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                // Handle any errors from the server
                alert('Sunucu hatası: ' + error); 
            }
        });
    } else {
        console.log('Ürün silme işlemi iptal edildi.');
    }
}

    </script>
</body>
</html>
