<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    //header("Refresh: url=../public/vista/login.php");
    header("Location: ../public/vista/login.html");
}