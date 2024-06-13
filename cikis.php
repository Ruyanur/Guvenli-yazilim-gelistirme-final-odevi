<!-- cikis.php -->
<?php
session_start();
session_destroy();
header("Location:giris.php");
require __DIR__ . '/session_functions.php';

logout();
?>
