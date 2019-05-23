<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("Location: ../../../public/vista/login.php");
} elseif ($_SESSION['rol'] == 'admin') {
    header("Location: ../../vista/admin/index.php");
}
include '../../../config/conexionBD.php';
$sql = "SELECT * FROM usuario usu, mensaje msj WHERE usu.usu_codigo=msj." . $_GET['code'] . " AND
                    msj.mail_codigo =" . $_GET['id'] . ";";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
echo ('<div class="formulario window">
    <p><span>' . $_GET['dest'] . '  </span>' . $row["usu_correo"] . '</p>
    <p><span>Asunto: </span>' . $row["mail_asunto"] . '</p>
    <p class="msj">' . $row["mail_mensaje"] . '</p>
    <input  type="button" value="Cerrar" onclick="cluseWindow()">
</div>');