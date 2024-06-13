
<?php
// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "abc123";
$dbname = "user_management";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $term = $_POST['term'] ?? '';

    // Güvenli bir SQL sorgusu hazırla
    $sql = "SELECT * FROM products WHERE urun_adi LIKE ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $term);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Sonuçları güvenli bir şekilde al
    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = [
            'urun_adi' => htmlspecialchars($row['urun_adi']),
            'fiyat' => htmlspecialchars($row['fiyat']),
            'kategori' => htmlspecialchars($row['kategori']),
            'stok' => htmlspecialchars($row['stok']),
            'aciklama' => htmlspecialchars($row['aciklama']),
            'eklenme_tarihi' => htmlspecialchars($row['eklenme_tarihi'])
        ];
    }

    // JSON formatına dönüştür ve yanıt olarak gönder
    echo json_encode($products);
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Ara</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
        input[type="text"], input[type="submit"] {
            width: calc(100% - 24px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"] {
            background: #4caf50;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Ürün Ara</h2>
        <form id="searchForm">
            <input type="text" id="search" placeholder="Ürün adı...">
            <input type="submit" value="Ara">
        </form>
        <div id="results"></div>
    </div>

    <script>
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const term = document.getElementById('search').value;
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status === 200) {
                    const products = JSON.parse(this.responseText);
                    let output = '<table>';
                    if (products.length > 0) {
                        output += `
                            <tr>
                                <th>Ürün Adı</th>
                                <th>Fiyat</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Açıklama</th>
                                <th>Eklenme Tarihi</th>
                            </tr>`;
                        products.forEach(product => {
                            output += `
                                <tr>
                                    <td>${product.urun_adi}</td>
                                    <td>${product.fiyat}</td>
                                    <td>${product.kategori}</td>
                                    <td>${product.stok}</td>
                                    <td>${product.aciklama}</td>
                                    <td>${product.eklenme_tarihi}</td>
                                </tr>`;
                        });
                    } else {
                        output += '<tr><td colspan="6">Ürün bulunamadı.</td></tr>'; // Hata mesajı
                    }
                    output += '</table>';
                    document.getElementById('results').innerHTML = output;
                } else {
                    document.getElementById('results').innerHTML = '<p>Bir hata oluştu. Lütfen tekrar deneyin.</p>'; // Diğer hata mesajı
                }
            };
            xhr.onerror = function() {
                document.getElementById('results').innerHTML = '<p>Bir hata oluştu. Sunucuya erişilemiyor.</p>'; // Bağlantı hatası mesajı
            };
            xhr.send('term=' + term);
        });
    </script>
</body>
</html>
