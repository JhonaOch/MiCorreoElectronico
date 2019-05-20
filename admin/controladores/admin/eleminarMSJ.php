<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("Location: ../../../public/vista/login.php");
} elseif ($_SESSION['rol'] == 'user') {
    header("Location: ../usuario/index.php");
}
?>
<?php
include '../../../config/conexionBD.php';
$cod = isset($_GET["usu_cod"]) ? trim($_GET["usu_cod"]) : null;
$sql = "DELETE FROM mensaje WHERE mail_codigo='$cod';";
if ($conn->query($sql) == true) {
    echo "Mesaje eliminado";
    header("Location: ../../vista/admin/index.php");
}
$conn->close();
?>