<?php
session_start();
if (isset($_POST['tgl_haid'])) {
    $_SESSION['last_period'] = $_POST['tgl_haid'];
}
header("Location: index.php");
exit();