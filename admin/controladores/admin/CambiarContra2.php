<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("");
} elseif ($_SESSION['rol'] == 'user') {
    header("Location: ../usuario/index.php");
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="">
    <
    <title>Modificar Usuario</title>
</head>

<body>
    <header>
        <h1 class="tittle">Gestion de usuarios</h1>
        <div class="menu">
            <nav>
                <ul>
                    <li><a href="../../vista/usuario/index.php">Inicio</a></li>
                    <li><a href="../../vista/usuario/UsuariosTabla.php">Usuarios</a></li>
                    <li><a href="../../vista/usuario/micuenta.php">Mi cuenta</a></li>
                    <li><a href="">Cerrar Sesion</a></li>
                </ul>
            </nav>
        </div>
        <div class="user">
            <div class="userImg">
                <div class="imagen">
                    <img src="<?php echo ('../../../img/fotos/' . $_SESSION["codigo"] . '/' . $_SESSION["img"]) ?>"
                        alt="">
                </div>
                <p><span><?php echo ($_SESSION['nombre'] . ' ' . $_SESSION['apellido']) ?></span></p>
            </div>
        </div>
    </header>
    <section>
        <div class="formulario crear_usuario">
            <?php
            


include '../../config/conexionBD.php';
$actual = isset($_POST["actual"]) ? trim($_POST["actual"]) : null;
$nueva = isset($_POST["nueva"]) ? trim($_POST["nueva"]) : null;
$repnueva = isset($_POST["repnueva"]) ? trim($_POST["repnueva"]) : null;
$cod = $_GET["usu_cod"];

$sql = "SELECT usu_password FROM usuario WHERE usu_codigo='$cod'";

$result = $conn->query($sql);
$result = $result->fetch_assoc();
$date = date(date("Y-m-d H:i:s"));

if (MD5($actual) === $result["usu_password"]) {
    if ($nueva === $repnueva) {
        $sql = "UPDATE usuario SET usu_password = MD5('$nueva') WHERE usu_codigo ='$cod'";
        if ($conn->query($sql) === true) {
            header("Location: ../../vista/usuario/UsuariosTabla.php");
        } else {
            header("Location: ../../vista/admin/CambiarContra2.php");
        }
    }
}

?>
</div>
</section>
</body>

</html>
