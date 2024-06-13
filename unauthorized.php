<?php
include 'auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Yetkisiz Erişim</title>

</head>
<body>
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

table {
    width: 100%;
    margin-bottom: 20px;
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid #ddd;
    padding: 12px;
}

th {
    background: #f5f5f5;
}

input[type="text"], input[type="password"], input[type="email"], textarea, select {
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

        </style>
    <div class="container">
        <h2>Yetkisiz Erişim</h2>
        <p>Bu sayfaya erişim izniniz yok.</p>
    </div>
</body>
</html>
