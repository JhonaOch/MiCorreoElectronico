<?php
session_start();
session_destroy();
if (isset($_SESSION['isLogin']) and $_SESSION['isLogin'] == true) {
    $_SESSION['isLogin'] = false;
    session_destroy();
}
header("Location: ../public/vista/login.php");