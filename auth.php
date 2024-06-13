<?php

function isAuthenticated() {
    return isset($_SESSION['user_id']);
}

function isAuthorized($role) {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $role;
}

function requireAuth() {
    if (!isAuthenticated()) {
        header('Location: giris.php');
        exit();
    }
}

function requireRole($role) {
    if (!isAuthorized($role)) {
        header('Location: unauthorized.php');
        exit();
    }
}
?>
