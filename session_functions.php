<?php
define('MAX_SESSION_DURATION', 1800); // Oturum süresi 30 dakika

function checkSessionTimeout() {
    if (isset($_SESSION['login_time'])) {
        if ((time() - $_SESSION['login_time']) > MAX_SESSION_DURATION) {
            logout();
            return false;
        }
        return true;
    }
    return false;
}

function logout() {
    $login_time = $_SESSION['login_time'];
    $logout_time = time();
    $session_duration = $logout_time - $login_time;

    // Veritabanı bağlantısı
    $conn = new mysqli('localhost', 'root', 'abc123', 'user_management');

    // Bağlantıyı kontrol et
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE users SET login_time = ?, logout_time = ?, session_duration = ? WHERE username = ?");
    $stmt->bind_param('ssis', date('Y-m-d H:i:s', $login_time), date('Y-m-d H:i:s', $logout_time), $session_duration, $_SESSION['username']);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    session_unset();
    session_destroy();
    header('Location: giris.php');
    exit();
}
?>
